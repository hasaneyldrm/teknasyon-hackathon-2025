@extends('layouts.admin')

@section('title', 'Dashboard - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Dashboard</h1>
    <p class="text-gray-400">Hoş geldiniz! GlobalGPT yönetim paneline.</p>
</div>

<!-- Stats Cards -->
<div class="p-6">
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Messages Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Toplam Mesaj</div>
                <div class="text-2xl font-semibold text-white mb-4" id="totalMessages">0</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M3 17l6 -6l4 4l8 -8"></path>
                            <path d="M14 7l7 0l0 7"></path>
                        </svg>
                        +12%
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Bu ay geçen aya göre artış</div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Aktif Kullanıcılar</div>
                <div class="text-2xl font-semibold text-white mb-4" id="activeUsers">0</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M5 12h14"></path>
                        </svg>
                        0%
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Online kullanıcılar</div>
            </div>
        </div>

        <!-- API Requests Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">API İstekleri</div>
                <div class="text-2xl font-semibold text-white mb-4" id="apiRequests">0</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M3 17l6 -6l4 4l8 -8"></path>
                            <path d="M14 7l7 0l0 7"></path>
                        </svg>
                        +8%
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Başarılı API çağrıları</div>
            </div>
        </div>

        <!-- Success Rate Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Başarı Oranı</div>
                <div class="text-2xl font-semibold text-white mb-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-lg font-bold text-green-400" id="successRate">98.5%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-lg font-bold text-red-400" id="errorRate">1.5%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Son 24 saat</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Usage Chart -->
        <div class="card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-400"></i>
                Kullanım İstatistikleri
            </h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="usageChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Response Times -->
        <div class="card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <i class="fas fa-clock text-green-400"></i>
                Yanıt Süreleri
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Ortalama</span>
                    <span class="text-white font-medium" id="avgResponseTime">1.2s</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">En Hızlı</span>
                    <span class="text-green-400 font-medium" id="fastestResponse">0.8s</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">En Yavaş</span>
                    <span class="text-red-400 font-medium" id="slowestResponse">3.1s</span>
                </div>
                <div class="mt-4">
                    <div class="text-sm text-gray-400 mb-2">Yanıt Süresi Dağılımı</div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">< 2s (75%)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 20%"></div>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">2-5s (20%)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 5%"></div>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">> 5s (5%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-history text-purple-400"></i>
                Son Aktiviteler
            </h3>
            <button class="text-blue-400 hover:text-blue-300 text-sm">
                Tümünü Gör
            </button>
        </div>
        <div class="space-y-4" id="recentActivities">
            <!-- Activities will be loaded here -->
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">Yeni mesaj alındı</div>
                    <div class="text-gray-400 text-xs">2 dakika önce</div>
                </div>
                <div class="text-gray-400 text-xs">Chat API</div>
            </div>
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">Sistem durumu kontrol edildi</div>
                    <div class="text-gray-400 text-xs">5 dakika önce</div>
                </div>
                <div class="text-gray-400 text-xs">System</div>
            </div>
            <div class="flex items-center gap-4 p-3 bg-gray-800 rounded-lg">
                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                <div class="flex-1">
                    <div class="text-white text-sm">OpenAI API limiti güncellendi</div>
                    <div class="text-gray-400 text-xs">1 saat önce</div>
                </div>
                <div class="text-gray-400 text-xs">API</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Load dashboard data
    loadDashboardData();
    
    // Initialize chart
    initializeChart();
    
    // Refresh data every 30 seconds
    setInterval(loadDashboardData, 30000);
});

function loadDashboardData() {
    // Simulate loading dashboard data
    // In real implementation, this would be an AJAX call to backend
    
    // Update stats with sample data
    $('#totalMessages').text('1,234');
    $('#activeUsers').text('42');
    $('#apiRequests').text('856');
    $('#avgResponseTime').text('1.2s');
    $('#fastestResponse').text('0.8s');
    $('#slowestResponse').text('3.1s');
    
    // You can add real AJAX call here:
    /*
    $.ajax({
        url: '/admin/dashboard-data',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                $('#totalMessages').text(response.data.total_messages);
                $('#activeUsers').text(response.data.active_users);
                $('#apiRequests').text(response.data.api_requests);
                // Update other fields...
            }
        },
        error: function(xhr, status, error) {
            console.error('Dashboard data loading error:', error);
        }
    });
    */
}

function initializeChart() {
    const ctx = document.getElementById('usageChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
            datasets: [{
                label: 'Mesajlar',
                data: [12, 19, 8, 25, 42, 38, 28],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'API Çağrıları',
                data: [8, 15, 12, 35, 28, 45, 22],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#9ca3af'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: '#374151'
                    }
                },
                y: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: '#374151'
                    }
                }
            }
        }
    });
}
</script>
@endsection
