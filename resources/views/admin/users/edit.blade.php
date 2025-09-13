@extends('layouts.admin')

@section('title', 'Kullanıcı Düzenle - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">Kullanıcı Düzenle</h1>
            <p class="text-gray-400">{{ $user->name }} kullanıcısının bilgilerini düzenleyin</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.show', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Görüntüle
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
    <div class="max-w-2xl mx-auto">
        <div class="card rounded-xl p-8 shadow-sm">
            <!-- User Avatar -->
            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-700">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-medium">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">{{ $user->name }}</h3>
                    <p class="text-gray-400">Kullanıcı ID: #{{ $user->id }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                
                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Ad Soyad <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Kullanıcının adını girin"
                           required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="kullanici@example.com"
                           required>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Yeni Şifre <span class="text-gray-500">(Boş bırakılırsa değiştirilmez)</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="En az 8 karakter">
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        Şifre Tekrarı
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Şifreyi tekrar girin">
                </div>

                <!-- UUID Display -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        UUID
                    </label>
                    <div class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-gray-400">
                        <code class="text-blue-400">{{ $user->uuid ?? 'Henüz oluşturulmadı' }}</code>
                    </div>
                </div>

                <!-- Token Display -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        API Token
                    </label>
                    <div class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-gray-400">
                        <code class="text-green-400">{{ $user->token ? substr($user->token, 0, 16) . '...' : 'Henüz oluşturulmadı' }}</code>
                    </div>
                </div>

                <!-- Coin Field -->
                <div class="mb-6">
                    <label for="coin" class="block text-sm font-medium text-gray-300 mb-2">
                        Coin Miktarı
                    </label>
                    <input type="number" 
                           id="coin" 
                           name="coin" 
                           value="{{ old('coin', $user->coin ?? 0) }}"
                           min="0"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0">
                    @error('coin')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- App Source Field -->
                <div class="mb-6">
                    <label for="app_source" class="block text-sm font-medium text-gray-300 mb-2">
                        Uygulama Kaynağı
                    </label>
                    <select id="app_source" 
                            name="app_source"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Uygulama seçin</option>
                        <option value="ios" {{ old('app_source', $user->app_source) == 'ios' ? 'selected' : '' }}>iOS App</option>
                        <option value="android" {{ old('app_source', $user->app_source) == 'android' ? 'selected' : '' }}>Android App</option>
                        <option value="web" {{ old('app_source', $user->app_source) == 'web' ? 'selected' : '' }}>Web App</option>
                        <option value="api" {{ old('app_source', $user->app_source) == 'api' ? 'selected' : '' }}>API</option>
                    </select>
                    @error('app_source')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Verified Checkbox -->
                <div class="mb-8">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="email_verified" 
                               value="1"
                               {{ $user->email_verified_at ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Email adresi doğrulanmış</span>
                    </label>
                    <p class="text-gray-400 text-sm mt-1">
                        @if($user->email_verified_at)
                            Email {{ $user->email_verified_at->format('d.m.Y H:i') }} tarihinde doğrulandı
                        @else
                            Email henüz doğrulanmadı
                        @endif
                    </p>
                </div>

                <!-- Account Info -->
                <div class="bg-gray-800 rounded-lg p-4 mb-8">
                    <h4 class="text-white font-medium mb-3">Hesap Bilgileri</h4>
                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-400">Kayıt Tarihi:</span>
                            <span class="text-white ml-2">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Son Güncelleme:</span>
                            <span class="text-white ml-2">{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                        İptal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17,21 17,13 7,13 7,21"></polyline>
                            <polyline points="7,3 7,8 15,8"></polyline>
                        </svg>
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="card rounded-xl p-6 shadow-sm mt-6 border border-red-500/20">
            <h3 class="text-lg font-semibold text-red-400 mb-4">Tehlikeli Bölge</h3>
            <p class="text-gray-400 text-sm mb-4">
                Bu kullanıcıyı silerseniz, tüm mesajları ve verileri kalıcı olarak silinecektir. Bu işlem geri alınamaz.
            </p>
            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz ve tüm veriler silinecektir!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3,6 5,6 21,6"></polyline>
                        <path d="m19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2-2V6m3,0V4a2,2 0 0,1,2-2h4a2,2 0 0,1,2,2v2"></path>
                    </svg>
                    Kullanıcıyı Kalıcı Olarak Sil
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
