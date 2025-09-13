@extends('layouts.admin')

@section('title', 'Proje Düzenle - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">Proje Düzenle</h1>
            <p class="text-gray-400">{{ $project->name }} projesini düzenleyin</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.projects.show', $project->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Görüntüle
            </a>
            <a href="{{ route('admin.projects') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
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
    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.projects.update', $project->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Project Header -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-700">
                            @if($project->logo)
                                <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="w-16 h-16 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white text-2xl font-medium">
                                    {{ substr($project->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-white">{{ $project->name }}</h3>
                                <p class="text-gray-400">Proje ID: #{{ $project->id }}</p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Project Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Proje Adı <span class="text-red-400">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $project->name) }}"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                          class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $project->description) }}</textarea>
                                @error('description')
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
                                    <option value="gpt-3.5-turbo" {{ old('model', $project->model) == 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
                                    <option value="gpt-4" {{ old('model', $project->model) == 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                                    <option value="gpt-4-turbo" {{ old('model', $project->model) == 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo</option>
                                    <option value="gemini-pro" {{ old('model', $project->model) == 'gemini-pro' ? 'selected' : '' }}>Gemini Pro</option>
                                </select>
                                @error('model')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', $project->is_active) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                                    <span class="ml-2 text-gray-300">Proje aktif</span>
                                </label>
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
                                       value="{{ old('temperature', $project->temperature) }}"
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
                                       value="{{ old('max_token', $project->max_token) }}"
                                       min="1" 
                                       max="4000"
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                <p class="text-gray-400 text-xs mt-1">1 - 4000 arası (Maksimum yanıt uzunluğu)</p>
                                @error('max_token')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
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
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="{{ $project->api_key ? 'Mevcut anahtar korunacak (boş bırakın)' : 'sk-...' }}">
                                <p class="text-gray-400 text-xs mt-1">
                                    @if($project->api_key)
                                        ✓ API anahtarı mevcut. Değiştirmek için yeni anahtarı girin.
                                    @else
                                        GPT modelleri için gerekli
                                    @endif
                                </p>
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
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="{{ $project->gemini_key ? 'Mevcut anahtar korunacak (boş bırakın)' : 'AIza...' }}">
                                <p class="text-gray-400 text-xs mt-1">
                                    @if($project->gemini_key)
                                        ✓ API anahtarı mevcut. Değiştirmek için yeni anahtarı girin.
                                    @else
                                        Gemini modelleri için gerekli
                                    @endif
                                </p>
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
                                <div id="logo-preview" class="w-24 h-24 mx-auto rounded-lg flex items-center justify-center">
                                    @if($project->logo)
                                        <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white text-2xl font-medium">
                                            {{ substr($project->name, 0, 1) }}
                                        </div>
                                    @endif
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
                                    {{ $project->logo ? 'Logo Değiştir' : 'Logo Seç' }}
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

                    <!-- Project Info -->
                    <div class="card rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-white mb-4">Proje Bilgileri</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Oluşturulma:</span>
                                <span class="text-white">{{ $project->created_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Son Güncelleme:</span>
                                <span class="text-white">{{ $project->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Proje ID:</span>
                                <span class="text-white">#{{ $project->id }}</span>
                            </div>
                        </div>
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
                                Değişiklikleri Kaydet
                            </button>
                            
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 17l-5-5 5-5"></path>
                                    <path d="M18 17l-5-5 5-5"></path>
                                </svg>
                                İptal
                            </a>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="card rounded-xl p-6 shadow-sm border border-red-500/20">
                        <h4 class="text-red-400 font-medium mb-3">⚠️ Tehlikeli Bölge</h4>
                        <p class="text-gray-400 text-sm mb-4">
                            Bu projeyi silerseniz tüm mesajlar ve veriler kalıcı olarak silinecektir.
                        </p>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}" onsubmit="return confirm('Bu projeyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3,6 5,6 21,6"></polyline>
                                    <path d="m19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2-2V6m3,0V4a2,2 0 0,1,2-2h4a2,2 0 0,1,2,2v2"></path>
                                </svg>
                                Projeyi Sil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
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
</script>
@endsection
