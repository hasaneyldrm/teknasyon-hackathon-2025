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
        return view('admin.dashboard');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function projects()
    {
        return view('admin.projects');
    }

    public function security()
    {
        return view('admin.security');
    }
}
