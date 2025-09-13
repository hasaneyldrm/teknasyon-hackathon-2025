@extends('layouts.admin')

@section('title', 'Yeni Kullanıcı - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">Yeni Kullanıcı Oluştur</h1>
            <p class="text-gray-400">Yeni bir kullanıcı hesabı oluşturun</p>
        </div>
        <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>
            Geri Dön
        </a>
    </div>
</div>

<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <div class="card rounded-xl p-8 shadow-sm">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                
                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Ad Soyad <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
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
                           value="{{ old('email') }}"
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
                        Şifre <span class="text-red-400">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="En az 8 karakter"
                           required>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        Şifre Tekrarı <span class="text-red-400">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Şifreyi tekrar girin"
                           required>
                </div>

                <!-- Coin Field -->
                <div class="mb-6">
                    <label for="coin" class="block text-sm font-medium text-gray-300 mb-2">
                        Başlangıç Coin Miktarı
                    </label>
                    <input type="number" 
                           id="coin" 
                           name="coin" 
                           value="{{ old('coin', 0) }}"
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
                        <option value="">Proje seçin</option>
                        @foreach(\App\Models\Project::where('is_active', true)->get() as $project)
                            <option value="{{ $project->name }}" {{ old('app_source') == $project->name ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
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
                               class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Email adresini doğrulanmış olarak işaretle</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors">
                        İptal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17,21 17,13 7,13 7,21"></polyline>
                            <polyline points="7,3 7,8 15,8"></polyline>
                        </svg>
                        Kullanıcı Oluştur
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="card rounded-xl p-6 shadow-sm mt-6">
            <h3 class="text-lg font-semibold text-white mb-4">Bilgi</h3>
            <div class="space-y-2 text-sm text-gray-300">
                <div class="flex items-start gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div>Şifre en az 8 karakter olmalıdır</div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div>Email adresi benzersiz olmalıdır</div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <div>Email doğrulama işareti kullanıcının email adresini hemen doğrulanmış yapar</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
