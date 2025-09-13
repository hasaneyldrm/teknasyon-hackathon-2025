@extends('layouts.admin')

@section('title', 'Projelerim - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white mb-2">Projelerim</h1>
            <p class="text-gray-400">AI projelerimi yönet ve düzenle</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                <line x1="12" y1="10" x2="12" y2="16"></line>
                <line x1="9" y1="13" x2="15" y2="13"></line>
            </svg>
            Yeni Proje
        </a>
    </div>
</div>

<div class="p-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

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
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['inactive_projects']) }}</div>
                    <div class="text-gray-400 text-sm">Pasif Proje</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    @if($projects->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($projects as $project)
            <div class="card rounded-xl p-6 shadow-sm hover:shadow-lg transition-shadow">
                <!-- Project Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($project->logo)
                            <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-medium">
                                {{ substr($project->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-white font-semibold">{{ $project->name }}</h4>
                            <p class="text-gray-400 text-sm">{{ $project->model }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        @if($project->is_active) bg-green-500/20 text-green-400
                        @else bg-red-500/20 text-red-400 @endif">
                        {{ $project->is_active ? 'Aktif' : 'Pasif' }}
                    </span>
                </div>

                <!-- Project Description -->
                @if($project->description)
                    <p class="text-gray-300 text-sm mb-4 line-clamp-2">{{ $project->description }}</p>
                @endif

                <!-- Project Stats -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Temperature:</span>
                        <span class="text-white">{{ $project->temperature }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Max Tokens:</span>
                        <span class="text-white">{{ number_format($project->max_token) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">OpenAI Key:</span>
                        <span class="{{ $project->api_key ? 'text-green-400' : 'text-red-400' }}">
                            {{ $project->api_key ? '✓ Var' : '✗ Yok' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Gemini Key:</span>
                        <span class="{{ $project->gemini_key ? 'text-green-400' : 'text-red-400' }}">
                            {{ $project->gemini_key ? '✓ Var' : '✗ Yok' }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.projects.show', $project->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm text-center transition-colors">
                        Görüntüle
                    </a>
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded text-sm text-center transition-colors">
                        Düzenle
                    </a>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}" class="inline" onsubmit="return confirm('Bu projeyi silmek istediğinizden emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition-colors">
                            Sil
                        </button>
                    </form>
                </div>

                <!-- Creation Date -->
                <div class="text-center text-xs text-gray-400 mt-3 pt-3 border-t border-gray-700">
                    {{ $project->created_at->format('d.m.Y') }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="card rounded-xl p-12 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-500">
                    <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">Henüz proje yok</h3>
                <p class="text-gray-400 mb-6">İlk AI projenizi oluşturmak için başlayın.</p>
                <a href="{{ route('admin.projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center gap-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    İlk Projemi Oluştur
                </a>
            </div>
        </div>
    @endif
</div>
@endsection