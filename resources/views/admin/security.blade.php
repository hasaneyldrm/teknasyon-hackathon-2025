@extends('layouts.admin')

@section('title', 'Güvenlik - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Güvenlik Yönetimi</h1>
    <p class="text-gray-400">Sistem güvenliğini izle ve yönet</p>
</div>

<div class="p-6">
    <!-- Security Stats -->
    <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m4.9 4.9 14.2 14.2"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($security['ip_bans']) }}</div>
                    <div class="text-gray-400 text-sm">IP Yasakları</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-400">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($security['active_bans']) }}</div>
                    <div class="text-gray-400 text-sm">Aktif Banlar</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400">
                        <path d="M3 17l6 -6l4 4l8 -8"></path>
                        <path d="M14 7l7 0l0 7"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($security['recent_requests']) }}</div>
                    <div class="text-gray-400 text-sm">Son 24 Saat</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                        <path d="M12 9v4"></path>
                        <path d="m12 17 .01 0"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($security['error_requests']) }}</div>
                    <div class="text-gray-400 text-sm">Hatalı İstekler</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400">
                        <path d="M12 2v10l3-3m-6 0 3 3"></path>
                        <path d="M12 22v-10l3 3m-6 0 3-3"></path>
                        <path d="M2 12h10l-3-3m0 6 3-3"></path>
                        <path d="M22 12H12l3-3m0 6-3-3"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($security['rate_limits']) }}</div>
                    <div class="text-gray-400 text-sm">Rate Limits</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Status -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- System Security Status -->
        <div class="card rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-white mb-4">Sistem Güvenlik Durumu</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-300">Firewall</span>
                    </div>
                    <span class="text-green-400 text-sm">Aktif</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-300">DDoS Koruması</span>
                    </div>
                    <span class="text-green-400 text-sm">Aktif</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-300">Rate Limiting</span>
                    </div>
                    <span class="text-green-400 text-sm">Aktif</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-300">IP Filtering</span>
                    </div>
                    <span class="text-green-400 text-sm">Aktif</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-300">Request Logging</span>
                    </div>
                    <span class="text-green-400 text-sm">Aktif</span>
                </div>
            </div>
        </div>

        <!-- Threat Level -->
        <div class="card rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-white mb-4">Tehdit Seviyesi</h3>
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 relative">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-gray-700" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        <path class="text-green-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="15, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">15%</div>
                        </div>
                    </div>
                </div>
                <div class="text-green-400 font-medium">DÜŞÜK</div>
                <div class="text-gray-400 text-sm mt-1">Sistem güvenli</div>
            </div>
        </div>
    </div>

    <!-- Recent IP Bans -->
    @if($recentBans->count() > 0)
    <div class="card rounded-xl p-6 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white">Son IP Yasakları</h3>
            <span class="text-sm text-gray-400">{{ $recentBans->count() }} kayıt</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">IP Adresi</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Tip</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Sebep</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Süre Sonu</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBans as $ban)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/20">
                        <td class="py-3 px-4">
                            <code class="text-blue-400 bg-gray-800 px-2 py-1 rounded text-sm">{{ $ban->ip_address }}</code>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($ban->type === 'permanent') bg-red-500/20 text-red-400
                                @else bg-orange-500/20 text-orange-400 @endif">
                                {{ $ban->type === 'permanent' ? 'Kalıcı' : 'Geçici' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-300">{{ Str::limit($ban->reason, 50) }}</td>
                        <td class="py-3 px-4 text-gray-400">
                            {{ $ban->expires_at ? $ban->expires_at->format('d.m.Y H:i') : 'Kalıcı' }}
                        </td>
                        <td class="py-3 px-4 text-gray-400">{{ $ban->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Recent Security Logs -->
    @if($recentLogs->count() > 0)
    <div class="card rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white">Son Güvenlik Logları</h3>
            <span class="text-sm text-gray-400">{{ $recentLogs->count() }} kayıt</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">IP</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Method</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Path</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Status</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Response Time</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentLogs as $log)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/20">
                        <td class="py-3 px-4">
                            <code class="text-blue-400 bg-gray-800 px-2 py-1 rounded text-xs">{{ $log->ip_address }}</code>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                @if($log->method === 'GET') bg-blue-500/20 text-blue-400
                                @elseif($log->method === 'POST') bg-green-500/20 text-green-400
                                @elseif($log->method === 'PUT') bg-yellow-500/20 text-yellow-400
                                @elseif($log->method === 'DELETE') bg-red-500/20 text-red-400
                                @else bg-gray-500/20 text-gray-400 @endif">
                                {{ $log->method }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-300">
                            <code class="text-sm">{{ Str::limit($log->path, 40) }}</code>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                @if($log->response_code >= 200 && $log->response_code < 300) bg-green-500/20 text-green-400
                                @elseif($log->response_code >= 300 && $log->response_code < 400) bg-yellow-500/20 text-yellow-400
                                @elseif($log->response_code >= 400 && $log->response_code < 500) bg-orange-500/20 text-orange-400
                                @else bg-red-500/20 text-red-400 @endif">
                                {{ $log->response_code }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-400">{{ $log->response_time }}ms</td>
                        <td class="py-3 px-4 text-gray-400">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Empty States -->
    @if($recentBans->count() === 0 && $recentLogs->count() === 0)
    <div class="card rounded-xl p-12 shadow-sm text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-500">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-white mb-2">Güvenlik Logları Temiz</h3>
        <p class="text-gray-400">Henüz güvenlik olayı kaydedilmedi. Sistem güvenli görünüyor.</p>
    </div>
    @endif
</div>
@endsection