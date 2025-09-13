@extends('layouts.admin')

@section('title', 'Yeni Proje - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">Yeni Proje Oluştur</h1>
            <p class="text-gray-400">Yeni bir AI projesi oluşturun</p>
        </div>
        <a href="{{ route('admin.projects') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>
            Geri Dön
        </a>
    </div>
</div>

<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-white mb-6">Temel Bilgiler</h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Project Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Proje Adı <span class="text-red-400">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Örn: ChatBot Projesi"
                                       required>
                                @error('name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                                    Açıklama
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="3"
                                          class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Proje hakkında kısa bir açıklama...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instructions -->
                            <div class="md:col-span-2">
                                <label for="instructions" class="block text-sm font-medium text-gray-300 mb-2">
                                    Sistem Talimatları <span class="text-red-400">*</span>
                                </label>
                                <textarea id="instructions" 
                                          name="instructions" 
                                          rows="5"
                                          class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Yapay zekaya verilecek sistem talimatlarını yazın... Örn: Sen bir Türkçe asistansın, her zaman Türkçe cevap vermelisin."
                                          required>{{ old('instructions') }}</textarea>
                                <p class="text-gray-400 text-xs mt-1">Bu talimatlar her sohbette yapay zekaya önceden verilir (pre-prompt)</p>
                                @error('instructions')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Model Selection -->
                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-300 mb-2">
                                    AI Modeli <span class="text-red-400">*</span>
                                </label>
                                <select id="model" 
                                        name="model" 
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="">Model Seçin</option>
                                    <option value="gpt-3.5-turbo" {{ old('model') == 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
                                    <option value="gpt-4" {{ old('model') == 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                                    <option value="gpt-4-turbo" {{ old('model') == 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo</option>
                                    <option value="gemini-pro" {{ old('model') == 'gemini-pro' ? 'selected' : '' }}>Gemini Pro</option>
                                    <option value="claude-3-sonnet" {{ old('model') == 'claude-3-sonnet' ? 'selected' : '' }}>Claude 3 Sonnet</option>
                                    <option value="claude-3-haiku" {{ old('model') == 'claude-3-haiku' ? 'selected' : '' }}>Claude 3 Haiku</option>
                                </select>
                                @error('model')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active') ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-2 text-gray-300">Projeyi aktif olarak başlat</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="enable_fallback" 
                                           value="1"
                                           id="enable_fallback"
                                           {{ old('enable_fallback') ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2"
                                           onchange="toggleFallbackSettings()">
                                    <span class="ml-2 text-gray-300">Akıllı Fallback Sistemi</span>
                                </label>
                                <p class="text-gray-400 text-xs ml-6">
                                    💡 API limitine takılırsa otomatik olarak diğer AI modellerine geçer
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- AI Configuration -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-white mb-6">AI Yapılandırması</h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Temperature -->
                            <div>
                                <label for="temperature" class="block text-sm font-medium text-gray-300 mb-2">
                                    Temperature <span class="text-red-400">*</span>
                                </label>
                                <input type="number" 
                                       id="temperature" 
                                       name="temperature" 
                                       value="{{ old('temperature', '0.7') }}"
                                       min="0" 
                                       max="1" 
                                       step="0.1"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                <p class="text-gray-400 text-xs mt-1">0.0 - 1.0 arası (Yaratıcılık seviyesi)</p>
                                @error('temperature')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Max Tokens -->
                            <div>
                                <label for="max_token" class="block text-sm font-medium text-gray-300 mb-2">
                                    Maksimum Token <span class="text-red-400">*</span>
                                </label>
                                <input type="number" 
                                       id="max_token" 
                                       name="max_token" 
                                       value="{{ old('max_token', '1000') }}"
                                       min="1" 
                                       max="4000"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                <p class="text-gray-400 text-xs mt-1">1 - 4000 arası (Maksimum yanıt uzunluğu)</p>
                                @error('max_token')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Token Limit -->
                            <div>
                                <label for="max_tokens_limit" class="block text-sm font-medium text-gray-300 mb-2">
                                    Token Tüketim Limiti <span class="text-red-400">*</span>
                                </label>
                                <input type="number" 
                                       id="max_tokens_limit" 
                                       name="max_tokens_limit" 
                                       value="{{ old('max_tokens_limit', '1000') }}"
                                       min="100" 
                                       max="10000"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                <p class="text-gray-400 text-xs mt-1">100 - 10000 arası (Kullanıcı ne kadar token tüketebilir)</p>
                                @error('max_tokens_limit')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Fallback Configuration -->
                    <div class="card rounded-xl p-6 shadow-sm" id="fallback-settings" style="display: none;">
                        <h3 class="text-lg font-semibold text-white mb-6">Fallback Sıralaması</h3>
                        
                        <div class="space-y-4">
                            <p class="text-gray-400 text-sm mb-4">
                                Primary model başarısız olursa hangi sırayla diğer modellere geçilsin?
                            </p>
                            
                            <div id="fallback-order-list" class="space-y-3">
                                <!-- JavaScript ile doldurulacak -->
                            </div>
                            
                            <div class="text-center">
                                <button type="button" onclick="resetToDefault()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    Varsayılan Sıralama
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- API Keys -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-white mb-6">API Anahtarları</h3>
                        
                        <div class="space-y-6">
                            <!-- OpenAI API Key -->
                            <div>
                                <label for="api_key" class="block text-sm font-medium text-gray-300 mb-2">
                                    OpenAI API Anahtarı
                                </label>
                                <input type="password" 
                                       id="api_key" 
                                       name="api_key" 
                                       value="{{ old('api_key') }}"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="sk-...">
                                <p class="text-gray-400 text-xs mt-1">GPT modelleri için gerekli</p>
                                @error('api_key')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gemini API Key -->
                            <div>
                                <label for="gemini_key" class="block text-sm font-medium text-gray-300 mb-2">
                                    Gemini API Anahtarı
                                </label>
                                <input type="password" 
                                       id="gemini_key" 
                                       name="gemini_key" 
                                       value="{{ old('gemini_key') }}"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="AIza...">
                                <p class="text-gray-400 text-xs mt-1">Gemini modelleri için gerekli</p>
                                @error('gemini_key')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Logo Upload -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-white mb-4">Proje Logosu</h3>
                        
                        <div class="text-center">
                            <div class="mb-4">
                                <div id="logo-preview" class="w-24 h-24 mx-auto bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white text-2xl font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                        <circle cx="12" cy="13" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <input type="file" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*"
                                       class="hidden"
                                       onchange="previewLogo(this)">
                                <label for="logo" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg cursor-pointer inline-flex items-center gap-2 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7,10 12,15 17,10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Logo Seç
                                </label>
                            </div>
                            
                            <p class="text-gray-400 text-xs">
                                JPG, PNG, GIF - Maksimum 2MB
                            </p>
                        </div>
                        
                        @error('logo')
                            <p class="text-red-400 text-sm mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <div class="space-y-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17,21 17,13 7,13 7,21"></polyline>
                                    <polyline points="7,3 7,8 15,8"></polyline>
                                </svg>
                                Projeyi Oluştur
                            </button>
                            
                            <a href="{{ route('admin.projects') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 17l-5-5 5-5"></path>
                                    <path d="M18 17l-5-5 5-5"></path>
                                </svg>
                                İptal
                            </a>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <h4 class="text-white font-medium mb-3">💡 Bilgi</h4>
                        <div class="space-y-2 text-sm text-gray-300">
                            <div>• API anahtarları güvenli şekilde şifrelenir</div>
                            <div>• Temperature düşük = tutarlı, yüksek = yaratıcı</div>
                            <div>• Max token yanıt uzunluğunu belirler</div>
                            <div>• Logo isteğe bağlıdır</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const models = {
    'gpt-3.5-turbo': 'GPT-3.5 Turbo',
    'gpt-4': 'GPT-4',
    'gpt-4-turbo': 'GPT-4 Turbo',
    'gemini-pro': 'Gemini Pro',
    'claude-3-sonnet': 'Claude 3 Sonnet',
    'claude-3-haiku': 'Claude 3 Haiku'
};

const defaultFallbacks = {
    'gpt-3.5-turbo': ['gemini-pro', 'claude-3-sonnet', 'claude-3-haiku'],
    'gpt-4': ['gemini-pro', 'claude-3-sonnet', 'claude-3-haiku'],
    'gpt-4-turbo': ['gemini-pro', 'claude-3-sonnet', 'claude-3-haiku'],
    'gemini-pro': ['gpt-3.5-turbo', 'claude-3-sonnet', 'gpt-4'],
    'claude-3-sonnet': ['gpt-3.5-turbo', 'gemini-pro', 'gpt-4'],
    'claude-3-haiku': ['gpt-3.5-turbo', 'gemini-pro', 'gpt-4']
};

function toggleFallbackSettings() {
    const checkbox = document.getElementById('enable_fallback');
    const settings = document.getElementById('fallback-settings');
    
    if (checkbox.checked) {
        settings.style.display = 'block';
        updateFallbackOrder();
    } else {
        settings.style.display = 'none';
    }
}

function updateFallbackOrder() {
    const primaryModel = document.getElementById('model').value;
    if (!primaryModel) return;
    
    const fallbacks = defaultFallbacks[primaryModel] || [];
    const container = document.getElementById('fallback-order-list');
    
    container.innerHTML = '';
    
    fallbacks.forEach((model, index) => {
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-3 bg-gray-700 rounded-lg';
        div.innerHTML = `
            <div class="flex items-center gap-3">
                <span class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-medium">${index + 1}</span>
                <span class="text-white">${models[model]}</span>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="moveFallback(${index}, -1)" ${index === 0 ? 'disabled' : ''} class="p-1 text-gray-400 hover:text-white disabled:opacity-50">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 12l-4-4h8l-4 4z"/>
                    </svg>
                </button>
                <button type="button" onclick="moveFallback(${index}, 1)" ${index === fallbacks.length - 1 ? 'disabled' : ''} class="p-1 text-gray-400 hover:text-white disabled:opacity-50">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 4l4 4H4l4-4z"/>
                    </svg>
                </button>
            </div>
            <input type="hidden" name="fallback_order[]" value="${model}">
        `;
        container.appendChild(div);
    });
}

function moveFallback(index, direction) {
    const container = document.getElementById('fallback-order-list');
    const items = Array.from(container.children);
    
    if (direction === -1 && index > 0) {
        container.insertBefore(items[index], items[index - 1]);
    } else if (direction === 1 && index < items.length - 1) {
        container.insertBefore(items[index + 1], items[index]);
    }
    
    updateFallbackOrder();
}

function resetToDefault() {
    updateFallbackOrder();
}

function previewLogo(input) {
    const preview = document.getElementById('logo-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="w-full h-full object-cover rounded-lg">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Model değiştiğinde fallback sıralamasını güncelle
document.getElementById('model').addEventListener('change', function() {
    if (document.getElementById('enable_fallback').checked) {
        updateFallbackOrder();
    }
});
</script>
@endsection
