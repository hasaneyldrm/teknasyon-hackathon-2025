@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-white mb-4">Geçmiş</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-pink-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Toplam Mesaj</h3>
            <p class="text-2xl font-bold">{{ number_format($chatStats['total_messages']) }}</p>
        </div>
        <div class="bg-purple-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Bu Hafta</h3>
            <p class="text-2xl font-bold">{{ number_format($chatStats['this_week_messages']) }}</p>
        </div>
        <div class="bg-green-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Toplam Kullanıcı</h3>
            <p class="text-2xl font-bold">{{ number_format($userStats['total_unique_users']) }}</p>
        </div>
        <div class="bg-yellow-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Aktif Proje</h3>
            <p class="text-2xl font-bold">{{ $popularProjects->count() }}</p>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Son 7 Gün Aktivite</h3>
        @if($monthlyActivity->count() > 0)
            <div class="space-y-2">
                @foreach($monthlyActivity as $activity)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300">{{ \Carbon\Carbon::parse($activity['date'])->format('d.m.Y') }}</span>
                        <span class="text-white font-bold">{{ $activity['count'] }} mesaj</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <p class="text-gray-400">Son 7 günde aktivite bulunmuyor</p>
            </div>
        @endif
    </div>

    <!-- Recent Chat Messages -->
    <div class="bg-gray-800 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Son Chat Mesajları</h3>
        @if($recentChats->count() > 0)
            <div class="space-y-3">
                @foreach($recentChats as $chat)
                    <div class="flex items-start space-x-3 p-3 bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-white text-sm font-medium">{{ substr($chat->user_uuid ?? 'Anonim', 0, 8) }}...</span>
                                <span class="text-gray-400 text-xs">{{ $chat->created_at->format('H:i d.m.Y') }}</span>
                            </div>
                            <p class="text-gray-300 text-sm mt-1">{{ Str::limit($chat->message ?? 'Mesaj yok', 100) }}</p>
                            @if($chat->response)
                                <p class="text-green-300 text-sm mt-2 italic">AI: {{ Str::limit($chat->response, 80) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <p class="text-gray-400">Henüz chat mesajı bulunmuyor</p>
            </div>
        @endif
    </div>

    <!-- System Activity Logs -->
    <div class="bg-gray-800 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Son Sistem Logları</h3>
        @if($systemActivity->count() > 0)
            <div class="space-y-3">
                @foreach($systemActivity as $log)
                    <div class="flex items-start space-x-3 p-3 bg-gray-700 rounded-lg">
                        <div class="w-2 h-2 bg-{{ $log->response_code >= 200 && $log->response_code < 300 ? 'green' : 'red' }}-500 rounded-full mt-2 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-white text-sm font-medium">{{ $log->method }} {{ Str::limit($log->path ?? $log->url ?? 'N/A', 50) }}</span>
                                <span class="text-gray-400 text-xs">{{ $log->created_at->format('H:i d.m.Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="px-2 py-1 bg-{{ $log->response_code >= 200 && $log->response_code < 300 ? 'green' : 'red' }}-100 text-{{ $log->response_code >= 200 && $log->response_code < 300 ? 'green' : 'red' }}-800 rounded text-xs">{{ $log->response_code }}</span>
                                <span class="text-gray-400 text-xs">{{ $log->response_time }}ms</span>
                                <span class="text-gray-400 text-xs">IP: {{ $log->ip_address }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-400">Henüz sistem logu bulunmuyor</p>
            </div>
        @endif
    </div>

    <!-- Popular Projects -->
    @if($popularProjects->count() > 0)
        <div class="bg-gray-800 rounded-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-white mb-4">En Popüler Projeler</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($popularProjects as $project)
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            @if($project->logo)
                                <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="w-10 h-10 rounded object-cover">
                            @else
                                <div class="w-10 h-10 bg-blue-500 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-white font-medium">{{ $project->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $project->chat_messages_count }} mesaj</p>
                                <p class="text-blue-400 text-xs">{{ $project->model }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection