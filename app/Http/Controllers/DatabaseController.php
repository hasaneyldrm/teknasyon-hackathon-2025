<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ChatMessage;
use App\Models\AdminUser;
use App\Models\Project;
use App\Models\IpBan;
use App\Models\RequestLog;

class DatabaseController extends Controller
{
    public function index()
    {
        $tables = $this->getTables();
        return view('admin.database', compact('tables'));
    }

    public function table(Request $request, $table)
    {
        try {
            $perPage = $request->get('per_page', 50);
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            // Güvenlik kontrolü - sadece belirli tabloları göster
            $allowedTables = [
                'users', 'admin_users', 'chat_messages', 'projects', 
                'ip_bans', 'rate_limits', 'request_logs', 'sessions',
                'cache', 'jobs', 'failed_jobs'
            ];

            if (!in_array($table, $allowedTables)) {
                return response()->json(['error' => 'Table not allowed'], 403);
            }

            // Tablo yapısını al
            $columns = Schema::getColumnListing($table);
            
            // Toplam kayıt sayısı
            $total = DB::table($table)->count();
            
            // Verileri al
            $data = DB::table($table)
                ->offset($offset)
                ->limit($perPage)
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();

            return response()->json([
                'table' => $table,
                'columns' => $columns,
                'data' => $data,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage)
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function stats()
    {
        try {
            $stats = [
                'users' => DB::table('users')->count(),
                'admin_users' => DB::table('admin_users')->count(),
                'chat_messages' => DB::table('chat_messages')->count(),
                'projects' => DB::table('projects')->count(),
                'ip_bans' => DB::table('ip_bans')->count(),
                'request_logs' => DB::table('request_logs')->count(),
                'recent_messages' => DB::table('chat_messages')->where('created_at', '>=', now()->subHours(24))->count(),
                'active_projects' => DB::table('projects')->where('is_active', true)->count(),
                'active_bans' => DB::table('ip_bans')
                    ->where(function($q) {
                        $q->where('type', 'permanent')
                          ->orWhere('expires_at', '>', now());
                    })->count(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getTables()
    {
        $tables = [];
        
        // Manuel olarak tabloları tanımlayalım
        $tableInfo = [
            'users' => ['count' => DB::table('users')->count(), 'description' => 'Kullanıcılar'],
            'admin_users' => ['count' => DB::table('admin_users')->count(), 'description' => 'Admin Kullanıcıları'],
            'chat_messages' => ['count' => DB::table('chat_messages')->count(), 'description' => 'Chat Mesajları'],
            'projects' => ['count' => DB::table('projects')->count(), 'description' => 'Projeler'],
            'ip_bans' => ['count' => DB::table('ip_bans')->count(), 'description' => 'IP Yasakları'],
            'request_logs' => ['count' => DB::table('request_logs')->count(), 'description' => 'İstek Logları'],
        ];

        foreach ($tableInfo as $tableName => $info) {
            $tables[] = [
                'name' => $tableName,
                'count' => $info['count'],
                'description' => $info['description']
            ];
        }

        return $tables;
    }
}
