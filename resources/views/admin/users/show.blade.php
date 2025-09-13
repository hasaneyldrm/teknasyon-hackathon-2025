@extends('layouts.admin')

@section('title', 'Kullanıcı Detayı - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">Kullanıcı Detayları</h1>
            <p class="text-gray-400">{{ $user->name }} kullanıcısının bilgileri</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Düzenle
            </a>
            <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
                Geri Dön
            </a>
        </div>
    </div>
</div>

<div class="p-6">
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- User Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-6">Temel Bilgiler</h3>
                
                <div class="space-y-6">
                    <!-- User Avatar and Name -->
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-medium">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-white">{{ $user->name }}</h4>
                            <p class="text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Ad Soyad</label>
                            <div class="text-white">{{ $user->name }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                            <div class="text-white">{{ $user->email }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email Durumu</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($user->email_verified_at) bg-green-500/20 text-green-400
                                @else bg-yellow-500/20 text-yellow-400 @endif">
                                @if($user->email_verified_at)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <polyline points="20,6 9,17 4,12"></polyline>
                                    </svg>
                                    Doğrulandı
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg>
                                    Bekliyor
                                @endif
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">UUID</label>
                            <div class="text-white">
                                <code class="bg-gray-800 text-blue-400 px-2 py-1 rounded text-sm">
                                    {{ $user->uuid ?? 'Henüz oluşturulmadı' }}
                                </code>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Coin Bakiyesi</label>
                            <div class="text-white">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400">
                                    {{ number_format($user->coin ?? 0) }} coin
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">API Token</label>
                            <div class="text-white">
                                <code class="bg-gray-800 text-green-400 px-2 py-1 rounded text-sm">
                                    {{ $user->token ? substr($user->token, 0, 16) . '...' : 'Henüz oluşturulmadı' }}
                                </code>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Proje</label>
                            <div class="text-white">
                                @if($user->project)
                                    <div class="flex items-center gap-3">
                                        @if($user->project->logo)
                                            <img src="{{ asset($user->project->logo) }}" alt="{{ $user->project->name }}" class="w-8 h-8 rounded">
                                        @else
                                            <div class="w-8 h-8 bg-blue-500 rounded flex items-center justify-center text-white text-sm">
                                                {{ substr($user->project->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-white font-medium">{{ $user->project->name }}</div>
                                            <div class="text-gray-400 text-xs">ID: {{ $user->project->id }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400">Proje atanmamış</span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email Doğrulama Tarihi</label>
                            <div class="text-white">
                                {{ $user->email_verified_at ? $user->email_verified_at->format('d.m.Y H:i') : 'Henüz doğrulanmadı' }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Kayıt Tarihi</label>
                            <div class="text-white">{{ $user->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Son Güncelleme</label>
                            <div class="text-white">{{ $user->updated_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Information -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-6">Aktivite Bilgileri</h3>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-400">{{ $userStats['total_messages'] }}</div>
                        <div class="text-gray-400 text-sm">Toplam Mesaj</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-400">
                            {{ $userStats['join_date']->diffForHumans() }}
                        </div>
                        <div class="text-gray-400 text-sm">Katılım Tarihi</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-400">
                            {{ $userStats['last_activity'] ? $userStats['last_activity']->diffForHumans() : 'Hiç' }}
                        </div>
                        <div class="text-gray-400 text-sm">Son Aktivite</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Hızlı İşlemler</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg flex items-center gap-3 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Kullanıcıyı Düzenle
                    </a>
                    
                    @if(!$user->email_verified_at)
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="w-full">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="email_verified" value="1">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg flex items-center gap-3 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20,6 9,17 4,12"></polyline>
                            </svg>
                            Email'i Doğrula
                        </button>
                    </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg flex items-center gap-3 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3,6 5,6 21,6"></polyline>
                                <path d="m19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2-2V6m3,0V4a2,2 0 0,1,2-2h4a2,2 0 0,1,2,2v2"></path>
                            </svg>
                            Kullanıcıyı Sil
                        </button>
                    </form>
                </div>
            </div>

            <!-- User Stats -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-4">İstatistikler</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Kullanıcı ID:</span>
                        <span class="text-white font-medium">#{{ $user->id }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">UUID:</span>
                        <span class="text-white font-medium text-xs">{{ $user->uuid ? substr($user->uuid, 0, 8) . '...' : 'N/A' }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Coin Bakiyesi:</span>
                        <span class="text-yellow-400 font-medium">{{ number_format($user->coin ?? 0) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Hesap Yaşı:</span>
                        <span class="text-white font-medium">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Son Güncelleme:</span>
                        <span class="text-white font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
