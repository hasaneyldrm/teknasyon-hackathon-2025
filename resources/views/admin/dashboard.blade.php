@extends('layouts.admin')

@section('title', 'Dashboard - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Dashboard</h1>
    <p class="text-gray-400">Hoş geldiniz! GlobalGPT yönetim paneline.</p>
</div>

<!-- Stats Cards -->
<div class="p-6">
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Toplam Kullanıcı</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['total_users']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                        </svg>
                        {{ $stats['admin_users'] }} admin
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Kayıtlı kullanıcılar</div>
            </div>
        </div>

        <!-- Chat Messages Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Chat Mesajları</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['total_messages']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $stats['recent_messages'] }} son 30 gün
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Toplam mesaj sayısı</div>
            </div>
        </div>

        <!-- Projects Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Projeler</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['total_projects']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                        </svg>
                        {{ $stats['active_projects'] }} aktif
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">AI projeleri</div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Güvenlik</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['ip_bans']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        {{ $stats['active_bans'] }} aktif ban
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">IP yasakları</div>
            </div>
        </div>
    </div>

    <!-- Request Statistics -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Request Stats -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">İstek İstatistikleri</h3>
                <div class="text-sm text-gray-400">Son 7 gün</div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Toplam İstek</span>
                    <span class="text-white font-medium">{{ number_format($stats['total_requests']) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Son 7 Gün</span>
                    <span class="text-green-400 font-medium">{{ number_format($stats['recent_requests']) }}</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_requests'] > 0 ? ($stats['recent_requests'] / $stats['total_requests']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Sistem Durumu</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-green-400 text-sm">Online</span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Database</span>
                    <span class="text-green-400">✓ MySQL</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">OpenAI API</span>
                    <span class="text-green-400">✓ Aktif</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Chat Servisi</span>
                    <span class="text-green-400">✓ Çalışıyor</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-white mb-4">Hızlı İşlemler</h3>
        <div class="grid md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400">
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">Kullanıcılar</div>
                    <div class="text-gray-400 text-sm">Yönet</div>
                </div>
            </a>

            <a href="{{ route('admin.projects') }}" class="flex items-center gap-3 p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400">
                        <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">Projeler</div>
                    <div class="text-gray-400 text-sm">Yönet</div>
                </div>
            </a>

            <a href="{{ route('admin.security') }}" class="flex items-center gap-3 p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-400">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">Güvenlik</div>
                    <div class="text-gray-400 text-sm">Yönet</div>
                </div>
            </a>

            <a href="http://localhost:8081" target="_blank" class="flex items-center gap-3 p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-400">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M3 5v14a9 3 0 0 0 18 0V5"></path>
                        <path d="M3 12a9 3 0 0 0 18 0"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-medium">phpMyAdmin</div>
                    <div class="text-gray-400 text-sm">Database</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection