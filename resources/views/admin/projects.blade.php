@extends('layouts.admin')

@section('title', 'Projeler - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Projeler</h1>
    <p class="text-gray-400">AI projelerini görüntüleyin ve yönetin</p>
</div>

<!-- Projects Content -->
<div class="p-6">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Toplam Proje</div>
                    <div class="text-2xl font-bold text-white">3</div>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Aktif Proje</div>
                    <div class="text-2xl font-bold text-white">2</div>
                </div>
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-play text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Bu Ay API</div>
                    <div class="text-2xl font-bold text-white">1.2K</div>
                </div>
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-code text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Başarı Oranı</div>
                    <div class="text-2xl font-bold text-white">98.5%</div>
                </div>
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- GlobalGPT Project -->
        <div class="card rounded-xl p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-robot text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold">GlobalGPT</h3>
                    <p class="text-gray-400 text-sm">AI Chat Assistant</p>
                </div>
            </div>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">API Çağrıları</span>
                    <span class="text-white font-medium">856</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Aktif Kullanıcılar</span>
                    <span class="text-white font-medium">42</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Başarı Oranı</span>
                    <span class="text-green-400 font-medium">99.2%</span>
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300">
                    <i class="fas fa-circle text-xs mr-1"></i>
                    Aktif
                </span>
                <div class="flex gap-2">
                    <button class="p-2 text-blue-400 hover:text-blue-300 transition-colors duration-200" title="Düzenle">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-300 transition-colors duration-200" title="Ayarlar">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- AI Assistant Project -->
        <div class="card rounded-xl p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-brain text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold">AI Assistant</h3>
                    <p class="text-gray-400 text-sm">Smart Helper Bot</p>
                </div>
            </div>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">API Çağrıları</span>
                    <span class="text-white font-medium">324</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Aktif Kullanıcılar</span>
                    <span class="text-white font-medium">18</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Başarı Oranı</span>
                    <span class="text-green-400 font-medium">97.8%</span>
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300">
                    <i class="fas fa-circle text-xs mr-1"></i>
                    Aktif
                </span>
                <div class="flex gap-2">
                    <button class="p-2 text-blue-400 hover:text-blue-300 transition-colors duration-200" title="Düzenle">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-300 transition-colors duration-200" title="Ayarlar">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Generator Project -->
        <div class="card rounded-xl p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pen-fancy text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Content Generator</h3>
                    <p class="text-gray-400 text-sm">AI Content Writer</p>
                </div>
            </div>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">API Çağrıları</span>
                    <span class="text-white font-medium">156</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Aktif Kullanıcılar</span>
                    <span class="text-white font-medium">7</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-sm">Başarı Oranı</span>
                    <span class="text-yellow-400 font-medium">95.1%</span>
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                    <i class="fas fa-pause text-xs mr-1"></i>
                    Beklemede
                </span>
                <div class="flex gap-2">
                    <button class="p-2 text-blue-400 hover:text-blue-300 transition-colors duration-200" title="Düzenle">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-gray-300 transition-colors duration-200" title="Ayarlar">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Add New Project Card -->
        <div class="card rounded-xl p-6 border-2 border-dashed border-gray-600 hover:border-gray-500 transition-colors duration-200 cursor-pointer" onclick="showNewProjectModal()">
            <div class="flex flex-col items-center justify-center h-full text-center">
                <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-plus text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-gray-400 font-medium mb-2">Yeni Proje</h3>
                <p class="text-gray-500 text-sm">Yeni bir AI projesi oluşturun</p>
            </div>
        </div>
    </div>
</div>

<!-- New Project Modal -->
<div id="newProjectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-white">Yeni Proje Oluştur</h3>
            <button onclick="closeNewProjectModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Proje Adı</label>
                <input type="text" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Proje adını girin">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Açıklama</label>
                <textarea class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Proje açıklaması"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Proje Tipi</label>
                <select class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Chat Bot</option>
                    <option>Content Generator</option>
                    <option>Data Analyzer</option>
                    <option>Custom AI</option>
                </select>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeNewProjectModal()" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    İptal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Oluştur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showNewProjectModal() {
    $('#newProjectModal').removeClass('hidden').addClass('flex');
}

function closeNewProjectModal() {
    $('#newProjectModal').removeClass('flex').addClass('hidden');
}
</script>
@endsection
