@extends('layouts.admin')

@section('title', 'Projeler - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Proje Yönetimi</h1>
    <p class="text-gray-400">AI projelerini görüntüle ve yönet</p>
</div>

<div class="p-6">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400">
                        <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['total_projects']) }}</div>
                    <div class="text-gray-400 text-sm">Toplam Proje</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-400">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['active_projects']) }}</div>
                    <div class="text-gray-400 text-sm">Aktif Proje</div>
                </div>
            </div>
        </div>

        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                        <path d="m21 2-1 1m-2 2-3 3m-2 2-1 1"></path>
                        <path d="m12 12-1 1-3 3-2 2-1 1"></path>
                        <path d="M2 21 21 2"></path>
                        <path d="m6 18 3-3 2-2 3-3 1-1"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['inactive_projects']) }}</div>
                    <div class="text-gray-400 text-sm">Pasif Proje</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="card rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white">AI Projeleri</h3>
            <span class="text-sm text-gray-400">{{ $projects->count() }} proje</span>
        </div>

        @if($projects->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                <div class="bg-gray-700 rounded-xl p-6 hover:bg-gray-600 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            @if($project->image)
                                <img src="{{ $project->image }}" alt="{{ $project->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($project->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-white font-semibold">{{ $project->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $project->model ?? 'gpt-3.5-turbo' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($project->is_active) bg-green-500/20 text-green-400
                            @else bg-red-500/20 text-red-400 @endif">
                            {{ $project->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>

                    @if($project->description)
                        <p class="text-gray-300 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                    @endif

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Temperature:</span>
                            <span class="text-white">{{ $project->temperature ?? 0.7 }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Max Tokens:</span>
                            <span class="text-white">{{ number_format($project->max_token ?? 1000) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">API Key:</span>
                            <span class="text-green-400">{{ $project->api_key ? '✓ Yapılandırıldı' : '✗ Eksik' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span>{{ $project->created_at->format('d.m.Y') }}</span>
                        <span>{{ $project->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-500">
                    <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                </svg>
                <p class="text-lg mb-2">Henüz proje bulunmuyor</p>
                <p class="text-sm">İlk AI projenizi oluşturmak için başlayın.</p>
            </div>
        @endif
    </div>

    <!-- Project Configuration Info -->
    @if($projects->count() > 0)
    <div class="card rounded-xl p-6 shadow-sm mt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Proje Ayarları Bilgisi</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-white font-medium mb-3">Desteklenen Modeller</h4>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-gray-300">gpt-3.5-turbo</span>
                        <span class="text-gray-500">(Varsayılan)</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <span class="text-gray-300">gpt-4</span>
                        <span class="text-gray-500">(Premium)</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <span class="text-gray-300">gpt-4-turbo</span>
                        <span class="text-gray-500">(En yeni)</span>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-white font-medium mb-3">Yapılandırma Parametreleri</h4>
                <div class="space-y-2 text-sm text-gray-300">
                    <div><strong>Temperature:</strong> 0.0-1.0 (Yaratıcılık seviyesi)</div>
                    <div><strong>Max Tokens:</strong> 1-4000 (Maksimum yanıt uzunluğu)</div>
                    <div><strong>API Key:</strong> OpenAI API anahtarı gerekli</div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection