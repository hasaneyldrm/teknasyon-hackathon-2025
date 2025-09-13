@extends('layouts.admin')

@section('title', 'Güvenlik - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Güvenlik</h1>
    <p class="text-gray-400">Sistem güvenliği ve erişim kontrolü yönetimi</p>
</div>

<!-- Security Content -->
<div class="p-6">
    <!-- Security Overview Cards -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Güvenlik Skoru</div>
                    <div class="text-2xl font-bold text-green-400">95/100</div>
                </div>
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Engellenen IP</div>
                    <div class="text-2xl font-bold text-red-400">12</div>
                </div>
                <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ban text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Başarısız Giriş</div>
                    <div class="text-2xl font-bold text-yellow-400">3</div>
                </div>
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">API Rate Limit</div>
                    <div class="text-2xl font-bold text-blue-400">85%</div>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tachometer-alt text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Sections -->
    <div class="grid lg:grid-cols-2 gap-6 mb-8">
        <!-- Rate Limiting -->
        <div class="card rounded-xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tachometer-alt text-white"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold">Rate Limiting</h3>
                    <p class="text-gray-400 text-sm">API isteklerini sınırla</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Dakika başı limit</span>
                    <span class="text-white font-medium">60 istek</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Saat başı limit</span>
                    <span class="text-white font-medium">1000 istek</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Günlük limit</span>
                    <span class="text-white font-medium">10000 istek</span>
                </div>
                <div class="pt-2">
                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Ayarları Düzenle
                    </button>
                </div>
            </div>
        </div>

        <!-- DDoS Protection -->
        <div class="card rounded-xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-virus text-white"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold">DDoS Koruması</h3>
                    <p class="text-gray-400 text-sm">Saldırı tespiti ve engelleme</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Durum</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        Aktif
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Hassaslık</span>
                    <span class="text-yellow-400 font-medium">Orta</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">Son saldırı</span>
                    <span class="text-gray-400">2 gün önce</span>
                </div>
                <div class="pt-2">
                    <button class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Ayarları Düzenle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Blocked IPs -->
    <div class="card rounded-xl p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-white">Engellenen IP Adresleri</h3>
                <p class="text-gray-400 text-sm">Sistemden engellenen IP adresleri</p>
            </div>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                <i class="fas fa-ban mr-2"></i>
                IP Engelle
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">IP Adresi</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Sebep</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Engelleme Tarihi</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Durum</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors duration-200">
                        <td class="py-3 px-4 text-white font-mono">192.168.1.100</td>
                        <td class="py-3 px-4 text-red-400">DDoS Saldırısı</td>
                        <td class="py-3 px-4 text-gray-300">15 Ekim 2024</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-900 text-red-300">
                                Engellendi
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-green-400 hover:text-green-300 mr-2" title="Engeli Kaldır">
                                <i class="fas fa-unlock"></i>
                            </button>
                            <button class="text-red-400 hover:text-red-300" title="Kalıcı Engelle">
                                <i class="fas fa-ban"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors duration-200">
                        <td class="py-3 px-4 text-white font-mono">10.0.0.55</td>
                        <td class="py-3 px-4 text-yellow-400">Şüpheli Aktivite</td>
                        <td class="py-3 px-4 text-gray-300">14 Ekim 2024</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                                İzleniyor
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <button class="text-red-400 hover:text-red-300 mr-2" title="Engelle">
                                <i class="fas fa-ban"></i>
                            </button>
                            <button class="text-gray-400 hover:text-gray-300" title="Beyaz Listeye Ekle">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Security Logs -->
    <div class="card rounded-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-white">Güvenlik Logları</h3>
                <p class="text-gray-400 text-sm">Son güvenlik olayları</p>
            </div>
            <button class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Logları İndir
            </button>
        </div>

        <div class="space-y-3">
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">Şüpheli IP adresi engellendi: 192.168.1.100</div>
                    <div class="text-gray-400 text-xs">15 Ekim 2024, 14:30</div>
                </div>
                <div class="text-red-400 text-xs font-medium">CRITICAL</div>
            </div>
            
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-yellow-500 rounded-full flex-shrink-0"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">Rate limit aşıldı: 10.0.0.55</div>
                    <div class="text-gray-400 text-xs">15 Ekim 2024, 13:45</div>
                </div>
                <div class="text-yellow-400 text-xs font-medium">WARNING</div>
            </div>
            
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">Güvenlik taraması tamamlandı</div>
                    <div class="text-gray-400 text-xs">15 Ekim 2024, 12:00</div>
                </div>
                <div class="text-blue-400 text-xs font-medium">INFO</div>
            </div>
            
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">Sistem güvenlik güncellemesi uygulandı</div>
                    <div class="text-gray-400 text-xs">14 Ekim 2024, 09:15</div>
                </div>
                <div class="text-green-400 text-xs font-medium">SUCCESS</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Security page functionality can be added here
    console.log('Security page loaded');
});
</script>
@endsection
