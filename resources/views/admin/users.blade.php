@extends('layouts.admin')

@section('title', 'Kullanıcılar - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Kullanıcı Yönetimi</h1>
    <p class="text-gray-400">Kullanıcıları görüntüle ve yönet</p>
</div>

<div class="p-6">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400">
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['total_users']) }}</div>
                    <div class="text-gray-400 text-sm">Toplam Kullanıcı</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['admin_users']) }}</div>
                    <div class="text-gray-400 text-sm">Admin Kullanıcı</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-400">
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['recent_users']) }}</div>
                    <div class="text-gray-400 text-sm">Son 30 Gün</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Users Section -->
    <div class="card rounded-xl p-6 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white">Admin Kullanıcıları</h3>
            <span class="text-sm text-gray-400">{{ $adminUsers->count() }} kullanıcı</span>
        </div>

        @if($adminUsers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Kullanıcı</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Email</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Rol</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Durum</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Son Giriş</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Oluşturulma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adminUsers as $admin)
                        <tr class="border-b border-gray-700/50 hover:bg-gray-700/20">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        {{ substr($admin->name, 0, 1) }}
                                    </div>
                                    <span class="text-white font-medium">{{ $admin->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-300">{{ $admin->email }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($admin->role === 'super_admin') bg-red-500/20 text-red-400
                                    @elseif($admin->role === 'admin') bg-purple-500/20 text-purple-400
                                    @else bg-blue-500/20 text-blue-400 @endif">
                                    {{ ucfirst($admin->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($admin->is_active) bg-green-500/20 text-green-400
                                    @else bg-red-500/20 text-red-400 @endif">
                                    {{ $admin->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-400">
                                {{ $admin->last_login_at ? $admin->last_login_at->diffForHumans() : 'Hiç' }}
                            </td>
                            <td class="py-3 px-4 text-gray-400">
                                {{ $admin->created_at->format('d.m.Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-500">
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                </svg>
                <p>Henüz admin kullanıcısı bulunmuyor.</p>
            </div>
        @endif
    </div>

    <!-- Regular Users Section -->
    <div class="card rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white">Normal Kullanıcılar</h3>
            <span class="text-sm text-gray-400">{{ $users->count() }} kullanıcı</span>
        </div>

        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Kullanıcı</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Email</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Email Doğrulama</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Oluşturulma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-gray-700/50 hover:bg-gray-700/20">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="text-white font-medium">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-300">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($user->email_verified_at) bg-green-500/20 text-green-400
                                    @else bg-yellow-500/20 text-yellow-400 @endif">
                                    {{ $user->email_verified_at ? 'Doğrulandı' : 'Bekliyor' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-400">
                                {{ $user->created_at->format('d.m.Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-500">
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                </svg>
                <p>Henüz normal kullanıcı bulunmuyor.</p>
            </div>
        @endif
    </div>
</div>
@endsection