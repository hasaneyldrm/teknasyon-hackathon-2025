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

            return response()->json([
                'success' => true,
                'message' => $reply,
                'user_uuid' => $userUuid,
                'conversation_id' => $conversationId,
                'tokens_used' => $tokensUsed,
                'response_time' => round($responseTime, 3)
            ]);

        } catch (\Exception $e) {
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

    public function history()
    {
        // Gelecekte sohbet geçmişi için kullanılabilir
        return response()->json([
            'success' => true,
            'history' => []
        ]);
    }

    public function settings()
    {
        // Gelecekte ayarlar sayfası için kullanılabilir
        return view('chat.settings');
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

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = \App\Models\User::latest()->paginate(15);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ]);

        return redirect()->route('admin.users')->with('success', 'Kullanıcı başarıyla oluşturuldu!');
    }

    public function showUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $userStats = [
            'total_messages' => \App\Models\ChatMessage::where('user_uuid', $user->id)->count(),
            'last_activity' => \App\Models\ChatMessage::where('user_uuid', $user->id)->latest()->first()?->created_at,
            'join_date' => $user->created_at,
        ];

        return view('admin.users.show', compact('user', 'userStats'));
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => $request->has('email_verified') ? now() : null,
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
            'api_key' => 'nullable|string',
            'gemini_key' => 'nullable|string',
            'model' => 'required|string|in:gpt-3.5-turbo,gpt-4,gpt-4-turbo,gemini-pro',
            'temperature' => 'required|numeric|between:0,1',
            'max_token' => 'required|integer|between:1,4000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userId = 1; // For now, use default user ID

        $data = $request->only(['name', 'description', 'api_key', 'gemini_key', 'model', 'temperature', 'max_token']);
        $data['user_id'] = $userId;
        $data['is_active'] = $request->has('is_active');

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
        $userId = 1; // For now, use default user ID
        $project = \App\Models\Project::where('user_id', $userId)->findOrFail($id);
        
        $projectStats = [
            'total_messages' => $project->chatMessages()->count(),
            'recent_messages' => $project->chatMessages()->where('created_at', '>=', now()->subDays(30))->count(),
            'last_activity' => $project->chatMessages()->latest()->first()?->created_at,
        ];

        return view('admin.projects.show', compact('project', 'projectStats'));
    }

    public function editProject($id)
    {
        $userId = 1; // For now, use default user ID
        $project = \App\Models\Project::where('user_id', $userId)->findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, $id)
    {
        $userId = 1; // For now, use default user ID
        $project = \App\Models\Project::where('user_id', $userId)->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'api_key' => 'nullable|string',
            'gemini_key' => 'nullable|string',
            'model' => 'required|string|in:gpt-3.5-turbo,gpt-4,gpt-4-turbo,gemini-pro',
            'temperature' => 'required|numeric|between:0,1',
            'max_token' => 'required|integer|between:1,4000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'model', 'temperature', 'max_token']);
        $data['is_active'] = $request->has('is_active');

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

        $project->update($data);

        return redirect()->route('admin.projects')->with('success', 'Proje başarıyla güncellendi!');
    }

    public function destroyProject($id)
    {
        $userId = 1; // For now, use default user ID
        $project = \App\Models\Project::where('user_id', $userId)->findOrFail($id);
        
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
}
