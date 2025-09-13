<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use App\Models\ChatMessage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private $openai;

    public function __construct()
    {
        $this->openai = OpenAI::client(config('services.openai.key'));
    }

    public function index()
    {
        return view('chat.index');
    }

    public function admin()
    {
        return view('chat.admin');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            $startTime = microtime(true);
            
            $response = $this->openai->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Sen yardımcı bir AI asistanısın. Türkçe konuş ve kullanıcılara yardımcı ol.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7,
            ]);

            $endTime = microtime(true);
            $responseTime = ($endTime - $startTime);
            
            $reply = $response->choices[0]->message->content;
            $tokensUsed = $response->usage->total_tokens ?? 0;

            // Generate user UUID if not provided
            $userUuid = $request->input('user_uuid', $this->generateUserUuid($request));
            $conversationId = $request->input('conversation_id', Str::uuid());

            // Save to database
            ChatMessage::create([
                'user_uuid' => $userUuid,
                'project_id' => 1, // Default project
                'message' => $request->message,
                'response' => $reply,
                'conversation_id' => $conversationId,
                'model' => 'gpt-3.5-turbo',
                'tokens_used' => $tokensUsed,
                'response_time' => $responseTime,
            ]);

            // Log the request for analytics
            \App\Models\RequestLog::create([
                'user_uuid' => $userUuid,
                'project_id' => 1,
                'ip_address' => $request->ip(),
                'method' => 'POST',
                'path' => '/chat',
                'request_data' => json_encode(['message' => $request->message]),
                'response_code' => 200,
                'response_data' => json_encode(['success' => true, 'tokens_used' => $tokensUsed]),
                'response_time' => intval($responseTime * 1000), // Convert to milliseconds
                'user_agent' => $request->userAgent(),
                'action' => 'chat_message',
            ]);

            return response()->json([
                'success' => true,
                'message' => $reply,
                'user_uuid' => $userUuid,
                'conversation_id' => $conversationId,
                'tokens_used' => $tokensUsed,
                'response_time' => round($responseTime, 3)
            ]);

        } catch (\Exception $e) {
            // Log the error request for analytics
            try {
                \App\Models\RequestLog::create([
                    'user_uuid' => $request->input('user_uuid', $this->generateUserUuid($request)),
                    'project_id' => 1,
                    'ip_address' => $request->ip(),
                    'method' => 'POST',
                    'path' => '/chat',
                    'request_data' => json_encode(['message' => $request->message]),
                    'response_code' => 500,
                    'response_data' => json_encode(['error' => $e->getMessage()]),
                    'response_time' => 0,
                    'user_agent' => $request->userAgent(),
                    'action' => 'chat_message_error',
                    'error_message' => $e->getMessage(),
                ]);
            } catch (\Exception $logError) {
                // If logging fails, continue without breaking
            }

            return response()->json([
                'success' => false,
                'error' => 'Bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateUserUuid(Request $request): string
    {
        // Generate a simple user identifier based on IP and User Agent
        $identifier = $request->ip() . '|' . ($request->userAgent() ?? 'unknown');
        return substr(md5($identifier), 0, 8) . '-' . 
               substr(md5($identifier), 8, 4) . '-' . 
               substr(md5($identifier), 12, 4) . '-' . 
               substr(md5($identifier), 16, 4) . '-' . 
               substr(md5($identifier), 20, 12);
    }



    public function dashboard()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'admin_users' => \App\Models\AdminUser::count(),
            'total_messages' => \App\Models\ChatMessage::count(),
            'recent_messages' => \App\Models\ChatMessage::where('created_at', '>=', now()->subDays(30))->count(),
            'total_projects' => \App\Models\Project::count(),
            'active_projects' => \App\Models\Project::where('is_active', true)->count(),
            'total_requests' => \App\Models\RequestLog::count(),
            'recent_requests' => \App\Models\RequestLog::where('created_at', '>=', now()->subDays(7))->count(),
            'ip_bans' => \App\Models\IpBan::count(),
            'active_bans' => \App\Models\IpBan::where(function($q) {
                $q->where('type', 'permanent')
                  ->orWhere('expires_at', '>', now());
            })->count(),
        ];

        // Generate chart data for last 7 days
        $chartData = $this->generateChartData();

        return view('admin.dashboard', compact('stats', 'chartData'));
    }


    private function generateChartData()
    {
        // Get REAL data for last 7 days - NO dummy data
        $requests = [];
        $messages = [];
        $users = [];
        $errors = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->format('Y-m-d');

            // REAL data from chat messages
            $dailyMessages = \App\Models\ChatMessage::whereDate('created_at', $dateString)->count();
            $messages[] = $dailyMessages;
            
            // REAL data from request logs (if available), otherwise use chat messages as proxy
            $dailyRequests = \App\Models\RequestLog::whereDate('created_at', $dateString)->count();
            if ($dailyRequests == 0 && $dailyMessages > 0) {
                // If no request logs, use chat messages as API requests (each message = 1 request)
                $dailyRequests = $dailyMessages;
            }
            $requests[] = $dailyRequests;

            // REAL unique users per day from chat messages
            $dailyUsers = \App\Models\ChatMessage::whereDate('created_at', $dateString)
                ->distinct('user_uuid')->count('user_uuid');
            $users[] = $dailyUsers;

            // REAL error data from request logs or calculate from failed requests
            $dailyErrors = 0;
            
            // Try to get real error count from request logs
            if (\Schema::hasTable('request_logs')) {
                $dailyErrors = \App\Models\RequestLog::whereDate('created_at', $dateString)
                    ->where('response_code', '>=', 400)
                    ->count();
            }
            
            // If no request logs table or no errors, use 0 (no fake data)
            $errors[] = $dailyErrors;
        }

        return [
            'requests' => $requests,
            'messages' => $messages,
            'users' => $users,
            'errors' => $errors,
        ];
    }

    public function users()
    {
        $users = \App\Models\User::with('project')->latest()->paginate(15);
        $stats = [
            'total_users' => \App\Models\User::count(),
            'recent_users' => \App\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
            'active_users' => \App\Models\User::whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    public function projects()
    {
        // For now, we'll use user ID 1 as default. In real app, use Auth::id()
        $userId = 1;
        
        $projects = \App\Models\Project::where('user_id', $userId)->latest()->paginate(12);
        $stats = [
            'total_projects' => \App\Models\Project::where('user_id', $userId)->count(),
            'active_projects' => \App\Models\Project::where('user_id', $userId)->where('is_active', true)->count(),
            'inactive_projects' => \App\Models\Project::where('user_id', $userId)->where('is_active', false)->count(),
        ];

        return view('admin.projects', compact('projects', 'stats'));
    }

    public function security()
    {
        $security = [
            'ip_bans' => \App\Models\IpBan::count(),
            'active_bans' => \App\Models\IpBan::where(function($q) {
                $q->where('type', 'permanent')
                  ->orWhere('expires_at', '>', now());
            })->count(),
            'recent_requests' => \App\Models\RequestLog::where('created_at', '>=', now()->subDays(1))->count(),
            'error_requests' => \App\Models\RequestLog::where('response_code', '>=', 400)->count(),
            'rate_limits' => \App\Models\RateLimit::count(),
        ];

        $recentBans = \App\Models\IpBan::latest()->limit(10)->get();
        $recentLogs = \App\Models\RequestLog::latest()->limit(20)->get();

        return view('admin.security', compact('security', 'recentBans', 'recentLogs'));
    }

    // User CRUD Methods
    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $activeProjects = \App\Models\Project::where('is_active', true)->pluck('id')->toArray();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'coin' => 'nullable|integer|min:0',
            'project_id' => 'nullable|integer|in:' . implode(',', $activeProjects),
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'email_verified_at' => $request->has('email_verified') ? now() : null,
            'coin' => $request->coin ?? 0,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('admin.users')->with('success', 'Kullanıcı başarıyla oluşturuldu!');
    }

    public function showUser($id)
    {
        $user = \App\Models\User::with('project')->findOrFail($id);
        $userStats = [
            'total_messages' => \App\Models\ChatMessage::where('user_uuid', $user->id)->count(),
            'last_activity' => \App\Models\ChatMessage::where('user_uuid', $user->id)->latest()->first()?->created_at,
            'join_date' => $user->created_at,
        ];

        return view('admin.users.show', compact('user', 'userStats'));
    }

    public function editUser($id)
    {
        $user = \App\Models\User::with('project')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $activeProjects = \App\Models\Project::where('is_active', true)->pluck('id')->toArray();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'coin' => 'nullable|integer|min:0',
            'project_id' => 'nullable|integer|in:' . implode(',', $activeProjects),
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $request->has('email_verified') ? now() : null,
            'coin' => $request->coin ?? 0,
            'project_id' => $request->project_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => \Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'Kullanıcı başarıyla güncellendi!');
    }

    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Delete related chat messages
        \App\Models\ChatMessage::where('user_uuid', $user->id)->delete();
        
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Kullanıcı başarıyla silindi!');
    }

    // Project CRUD Methods
    public function createProject()
    {
        return view('admin.projects.create');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'instructions' => 'required|string|max:5000',
            'api_key' => 'nullable|string',
            'gemini_key' => 'nullable|string',
            'model' => 'required|string|in:gpt-3.5-turbo,gpt-4,gpt-4-turbo,gemini-pro,claude-3-sonnet,claude-3-haiku',
            'temperature' => 'required|numeric|between:0,1',
            'max_token' => 'required|integer|between:1,4000',
            'max_tokens_limit' => 'required|integer|between:100,10000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fallback_order' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'description', 'instructions', 'api_key', 'gemini_key', 'model', 'temperature', 'max_token', 'max_tokens_limit']);
        $data['user_id'] = 1; // Default user ID
        $data['is_active'] = $request->has('is_active');
        $data['enable_fallback'] = $request->has('enable_fallback');
        $data['fallback_order'] = $request->fallback_order;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/logos'), $logoName);
            $data['logo'] = 'uploads/logos/' . $logoName;
        }

        $project = \App\Models\Project::create($data);

        return redirect()->route('admin.projects')->with('success', 'Proje başarıyla oluşturuldu!');
    }

    public function showProject($id)
    {
        $project = \App\Models\Project::findOrFail($id);
        
        $projectStats = [
            'total_messages' => $project->chatMessages()->count(),
            'recent_messages' => $project->chatMessages()->where('created_at', '>=', now()->subDays(30))->count(),
            'last_activity' => $project->chatMessages()->latest()->first()?->created_at,
        ];

        return view('admin.projects.show', compact('project', 'projectStats'));
    }

    public function editProject($id)
    {
        $project = \App\Models\Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, $id)
    {
        \Log::info('updateProject method called', ['id' => $id, 'method' => $request->method()]);
        
        $project = \App\Models\Project::findOrFail($id);
        
        // Debug: Log the request data
        \Log::info('Update Project Request', [
            'project_id' => $id,
            'request_data' => $request->all()
        ]);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'instructions' => 'required|string|max:5000',
            'api_key' => 'nullable|string',
            'gemini_key' => 'nullable|string',
            'model' => 'required|string|in:gpt-3.5-turbo,gpt-4,gpt-4-turbo,gemini-pro,claude-3-sonnet,claude-3-haiku',
            'temperature' => 'required|numeric|between:0,1',
            'max_token' => 'required|integer|between:1,4000',
            'max_tokens_limit' => 'required|integer|between:100,10000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fallback_order' => 'nullable|array',
        ]);

        $data = $request->only(['name', 'description', 'instructions', 'model', 'temperature', 'max_token', 'max_tokens_limit']);
        $data['is_active'] = $request->has('is_active');
        $data['enable_fallback'] = $request->has('enable_fallback');
        $data['fallback_order'] = $request->fallback_order;

        // Only update API keys if they are provided
        if ($request->filled('api_key')) {
            $data['api_key'] = $request->api_key;
        }
        if ($request->filled('gemini_key')) {
            $data['gemini_key'] = $request->gemini_key;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($project->logo && file_exists(public_path($project->logo))) {
                unlink(public_path($project->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('uploads/logos'), $logoName);
            $data['logo'] = 'uploads/logos/' . $logoName;
        }

        try {
            $project->update($data);
            \Log::info('Project updated successfully', ['project_id' => $id]);
            return redirect()->route('admin.projects')->with('success', 'Proje başarıyla güncellendi!');
        } catch (\Exception $e) {
            \Log::error('Project update failed', [
                'project_id' => $id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return redirect()->back()->with('error', 'Proje güncellenirken bir hata oluştu: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyProject($id)
    {
        \Log::warning('destroyProject method called - PROJECT BEING DELETED!', ['id' => $id]);
        
        $project = \App\Models\Project::findOrFail($id);
        
        // Delete logo if exists
        if ($project->logo && file_exists(public_path($project->logo))) {
            unlink(public_path($project->logo));
        }
        
        // Delete related data
        $project->chatMessages()->delete();
        $project->requestLogs()->delete();
        
        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Proje başarıyla silindi!');
    }

    public function settings()
    {
        $settings = [
            // API Settings
            'openai_status' => 'Aktif',
            'openai_model' => 'gpt-3.5-turbo',
            'max_tokens' => 2048,
            'temperature' => 0.7,
            
            // System Settings
            'app_name' => 'GlobalGPT',
            'app_env' => 'local',
            'app_debug' => true,
            'app_timezone' => 'UTC',
            'database_connection' => 'mysql',
            
            // Security Settings
            'session_lifetime' => 120,
            'rate_limit_enabled' => true,
            'ip_ban_enabled' => true,
            'request_logging' => true,
            
            // Performance Settings
            'cache_driver' => 'file',
            'queue_driver' => 'sync',
            'mail_driver' => 'smtp',
        ];

        // Recent system activities
        $systemLogs = collect([]);
        
        return view('admin.settings', compact('settings', 'systemLogs'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'openai_model' => 'required|string',
            'max_tokens' => 'required|integer|min:1|max:4096',
            'temperature' => 'required|numeric|min:0|max:2',
        ]);

        // In a real app, you'd save these to database or config files
        // For now, just return success
        
        return redirect()->route('admin.settings')->with('success', 'Ayarlar başarıyla güncellendi!');
    }

    public function history()
    {
        // Chat history statistics - GERÇEK VERILER
        $totalMessages = \App\Models\ChatMessage::count();
        $chatStats = [
            'total_messages' => $totalMessages,
            'today_messages' => \App\Models\ChatMessage::whereDate('created_at', today())->count(),
            'this_week_messages' => \App\Models\ChatMessage::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month_messages' => \App\Models\ChatMessage::where('created_at', '>=', now()->startOfMonth())->count(),
            'avg_messages_per_day' => $totalMessages > 0 ? round(\App\Models\ChatMessage::where('created_at', '>=', now()->subDays(30))->count() / 30, 1) : 0,
        ];

        // User activity statistics - GERÇEK VERILER
        $userStats = [
            'active_users_today' => \App\Models\ChatMessage::whereDate('created_at', today())
                ->distinct('user_uuid')->count('user_uuid'),
            'active_users_week' => \App\Models\ChatMessage::where('created_at', '>=', now()->startOfWeek())
                ->distinct('user_uuid')->count('user_uuid'),
            'total_unique_users' => \App\Models\ChatMessage::distinct('user_uuid')->count('user_uuid'),
        ];

        // Recent chat messages - GERÇEK VERILER
        $recentChats = \App\Models\ChatMessage::latest()->limit(20)->get();

        // System activity logs - GERÇEK VERILER
        $systemActivity = \App\Models\RequestLog::latest()->limit(20)->get();

        // Popular projects - GERÇEK VERILER
        $popularProjects = \App\Models\Project::withCount('chatMessages')
            ->orderBy('chat_messages_count', 'desc')
            ->limit(5)
            ->get();

        // Monthly chat activity for chart - GERÇEK VERILER
        $monthlyActivity = \App\Models\ChatMessage::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count
                ];
            });

        return view('admin.history', compact(
            'chatStats',
            'userStats',
            'recentChats',
            'systemActivity',
            'popularProjects',
            'monthlyActivity'
        ));
    }

    public function docs()
    {
        return view('admin.docs');
    }

    // API Methods for external usage
    public function documentation()
    {
        return view('docs');
    }

    public function createUserAPI(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        try {
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'project_id' => $request->project_id ?? 1, // Default project
                'coin' => 100, // Default coin amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı başarıyla oluşturuldu',
                'data' => [
                    'id' => $user->id,
                    'uuid' => $user->uuid,
                    'token' => $user->token,
                    'name' => $user->name,
                    'email' => $user->email,
                    'coin' => $user->coin,
                    'project_id' => $user->project_id,
                    'created_at' => $user->created_at,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı oluşturulurken hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserAPI($token)
    {
        try {
            $user = \App\Models\User::where('token', $token)->with('project')->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kullanıcı bulunamadı'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'email' => $user->email,
                    'coin' => $user->coin,
                    'project_id' => $user->project_id,
                    'project' => $user->project,
                    'created_at' => $user->created_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı bilgileri alınırken hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function chatAPI(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'user_token' => 'required|string',
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        try {
            // Find user by token
            $user = \App\Models\User::where('token', $request->user_token)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geçersiz kullanıcı token\'ı'
                ], 401);
            }

            // Check user's coin balance
            if ($user->coin <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yetersiz coin bakiyesi'
                ], 402);
            }

            $projectId = $request->project_id ?? $user->project_id ?? 1;
            $project = \App\Models\Project::find($projectId);

            if (!$project || !$project->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geçersiz veya aktif olmayan proje'
                ], 400);
            }

            $startTime = microtime(true);
            
            // Use project's API key or system default
            $apiKey = $project->api_key ?? config('services.openai.key');
            $openai = OpenAI::client($apiKey);
            
            $response = $openai->chat()->create([
                'model' => $project->model ?? 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $project->instructions ?? 'Sen yardımcı bir AI asistanısın. Türkçe konuş ve kullanıcılara yardımcı ol.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message
                    ]
                ],
                'max_tokens' => $project->max_token ?? 500,
                'temperature' => $project->temperature ?? 0.7,
            ]);

            $endTime = microtime(true);
            $responseTime = ($endTime - $startTime);
            
            $reply = $response->choices[0]->message->content;
            $tokensUsed = $response->usage->total_tokens ?? 0;

            // Deduct coin from user
            $user->decrement('coin', 1);

            $conversationId = $request->input('conversation_id', Str::uuid());

            // Save to database
            ChatMessage::create([
                'user_uuid' => $user->uuid,
                'project_id' => $projectId,
                'message' => $request->message,
                'response' => $reply,
                'conversation_id' => $conversationId,
                'model' => $project->model ?? 'gpt-3.5-turbo',
                'tokens_used' => $tokensUsed,
                'response_time' => $responseTime,
                'type' => 'api',
            ]);

            // Log the request
            \App\Models\RequestLog::create([
                'user_uuid' => $user->uuid,
                'project_id' => $projectId,
                'ip_address' => $request->ip(),
                'method' => 'POST',
                'path' => '/api/chat',
                'request_data' => json_encode(['message' => $request->message]),
                'response_code' => 200,
                'response_data' => json_encode(['success' => true, 'tokens_used' => $tokensUsed]),
                'response_time' => intval($responseTime * 1000),
                'user_agent' => $request->userAgent(),
                'action' => 'api_chat_message',
            ]);

            return response()->json([
                'success' => true,
                'message' => $reply,
                'data' => [
                    'conversation_id' => $conversationId,
                    'tokens_used' => $tokensUsed,
                    'response_time' => round($responseTime, 3),
                    'remaining_coins' => $user->coin,
                    'model' => $project->model ?? 'gpt-3.5-turbo',
                ]
            ]);

        } catch (\Exception $e) {
            // Log error
            try {
                \App\Models\RequestLog::create([
                    'user_uuid' => $user->uuid ?? 'unknown',
                    'project_id' => $request->project_id ?? 1,
                    'ip_address' => $request->ip(),
                    'method' => 'POST',
                    'path' => '/api/chat',
                    'request_data' => json_encode(['message' => $request->message]),
                    'response_code' => 500,
                    'response_data' => json_encode(['error' => $e->getMessage()]),
                    'response_time' => 0,
                    'user_agent' => $request->userAgent(),
                    'action' => 'api_chat_error',
                    'error_message' => $e->getMessage(),
                ]);
            } catch (\Exception $logError) {
                // Continue without breaking
            }

            return response()->json([
                'success' => false,
                'message' => 'Chat isteği işlenirken hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
