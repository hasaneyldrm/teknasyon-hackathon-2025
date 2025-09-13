@extends('layouts.admin')

@section('title', 'Proje Detayı - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">{{ $project->name }}</h1>
            <p class="text-gray-400">Proje detayları ve istatistikleri</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Düzenle
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
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Info -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-6">Proje Bilgileri</h3>
                
                <div class="flex items-center gap-4 mb-6">
                    @if($project->logo)
                        <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white text-2xl font-medium">
                            {{ substr($project->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="text-xl font-semibold text-white">{{ $project->name }}</h4>
                        <p class="text-gray-400">{{ $project->model }}</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-2
                            @if($project->is_active) bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400 @endif">
                            {{ $project->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                </div>

                @if($project->description)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Açıklama</label>
                        <p class="text-white">{{ $project->description }}</p>
                    </div>
                @endif

                @if($project->instructions)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Sistem Talimatları (Pre-prompt)</label>
                        <div class="bg-gray-800 rounded-lg p-4">
                            <p class="text-white text-sm leading-relaxed">{{ $project->instructions }}</p>
                        </div>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">AI Modeli</label>
                        <div class="text-white">{{ $project->model }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Durum</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($project->is_active) bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400 @endif">
                            {{ $project->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Temperature</label>
                        <div class="text-white">{{ $project->temperature }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Max Tokens</label>
                        <div class="text-white">{{ number_format($project->max_token) }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Token Tüketim Limiti</label>
                        <div class="text-white">{{ number_format($project->max_tokens_limit ?? 1000) }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">OpenAI API Key</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($project->api_key) bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400 @endif">
                            @if($project->api_key)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polyline points="20,6 9,17 4,12"></polyline>
                                </svg>
                                Yapılandırıldı
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Eksik
                            @endif
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Gemini API Key</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($project->gemini_key) bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400 @endif">
                            @if($project->gemini_key)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <polyline points="20,6 9,17 4,12"></polyline>
                                </svg>
                                Yapılandırıldı
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Eksik
                            @endif
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Oluşturulma Tarihi</label>
                        <div class="text-white">{{ $project->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Son Güncelleme</label>
                        <div class="text-white">{{ $project->updated_at->format('d.m.Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Activity Stats -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-6">Aktivite İstatistikleri</h3>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-400">{{ $projectStats['total_messages'] }}</div>
                        <div class="text-gray-400 text-sm">Toplam Mesaj</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-400">{{ $projectStats['recent_messages'] }}</div>
                        <div class="text-gray-400 text-sm">Son 30 Gün</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-400">
                            {{ $projectStats['last_activity'] ? $projectStats['last_activity']->diffForHumans() : 'Hiç' }}
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
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg flex items-center gap-3 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Projeyi Düzenle
                    </a>
                    
                    <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}" onsubmit="return confirm('Bu projeyi silmek istediğinizden emin misiniz? Tüm veriler silinecektir!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg flex items-center gap-3 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3,6 5,6 21,6"></polyline>
                                <path d="m19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2-2V6m3,0V4a2,2 0 0,1,2-2h4a2,2 0 0,1,2,2v2"></path>
                            </svg>
                            Projeyi Sil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Project Stats -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Proje İstatistikleri</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Proje ID:</span>
                        <span class="text-white font-medium">#{{ $project->id }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Yaş:</span>
                        <span class="text-white font-medium">{{ $project->created_at->diffInDays(now()) }} gün</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Son Güncelleme:</span>
                        <span class="text-white font-medium">{{ $project->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Model Info -->
            <div class="card rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-4">Model Bilgisi</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-white">{{ $project->model }}</span>
                    </div>
                    <div class="text-gray-400 text-sm">
                        @switch($project->model)
                            @case('gpt-3.5-turbo')
                                Hızlı ve ekonomik model
                                @break
                            @case('gpt-4')
                                Güçlü ve akıllı model
                                @break
                            @case('gpt-4-turbo')
                                En yeni ve hızlı model
                                @break
                            @case('gemini-pro')
                                Google'ın güçlü modeli
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
