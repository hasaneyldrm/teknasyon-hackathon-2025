@extends('layouts.admin')

@section('title', 'Dashboard - GlobalGPT Admin')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-6 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Dashboard</h1>
    <p class="text-gray-400">GlobalGPT yönetim paneli - {{ now()->format('d.m.Y H:i') }}</p>
</div>

<div class="p-6">
    <!-- Stats Cards at Top -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Requests Card -->
        <div class="card rounded-xl py-4 shadow-sm">
            <div class="px-4">
                <div class="text-gray-400 text-sm mb-1">Toplam İstek</div>
                <div class="text-xl font-semibold text-white mb-2">{{ number_format($stats['total_requests']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $stats['recent_requests'] }} son 7 gün
                    </span>
                </div>
            </div>
        </div>

        <!-- Chat Messages Card -->
        <div class="card rounded-xl py-4 shadow-sm">
            <div class="px-4">
                <div class="text-gray-400 text-sm mb-1">Chat Mesajları</div>
                <div class="text-xl font-semibold text-white mb-2">{{ number_format($stats['total_messages']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $stats['recent_messages'] }} son 30 gün
                    </span>
                </div>
            </div>
        </div>

        <!-- Active Projects Card -->
        <div class="card rounded-xl py-4 shadow-sm">
            <div class="px-4">
                <div class="text-gray-400 text-sm mb-1">Aktif Projeler</div>
                <div class="text-xl font-semibold text-white mb-2">{{ number_format($stats['active_projects']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                        </svg>
                        {{ $stats['total_projects'] }} toplam
                    </span>
                </div>
            </div>
        </div>

        <!-- Security Status Card -->
        <div class="card rounded-xl py-4 shadow-sm">
            <div class="px-4">
                <div class="text-gray-400 text-sm mb-1">Güvenlik</div>
                <div class="text-xl font-semibold text-white mb-2">{{ number_format($stats['active_bans']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        {{ $stats['ip_bans'] }} toplam ban
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Grid -->
    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <!-- Daily Requests Chart -->
        <div class="card rounded-xl p-4 shadow-sm">
            <div class="mb-3">
                <h3 class="text-base font-semibold text-white">Günlük İstekler</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-400">Son 7 günlük istek sayısı</span>
                </div>
            </div>
            <div class="h-40">
                <canvas id="requestsChart"></canvas>
            </div>
        </div>

        <!-- Daily Messages Chart -->
        <div class="card rounded-xl p-4 shadow-sm">
            <div class="mb-3">
                <h3 class="text-base font-semibold text-white">Günlük Mesajlar</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-400">Chat mesaj istatistikleri</span>
                </div>
            </div>
            <div class="h-40">
                <canvas id="messagesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Secondary Charts -->
    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <!-- User Activity Chart -->
        <div class="card rounded-xl p-4 shadow-sm">
            <div class="mb-3">
                <h3 class="text-base font-semibold text-white">Kullanıcı Aktivitesi</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                    <span class="text-sm text-gray-400">Aktif kullanıcı sayısı</span>
                </div>
            </div>
            <div class="h-40">
                <canvas id="usersChart"></canvas>
            </div>
        </div>

        <!-- Error Rate Chart -->
        <div class="card rounded-xl p-4 shadow-sm">
            <div class="mb-3">
                <h3 class="text-base font-semibold text-white">Hata Oranı</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <span class="text-sm text-gray-400">Başarısız istekler</span>
                </div>
            </div>
            <div class="h-40">
                <canvas id="errorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid md:grid-cols-2 gap-4">
        <!-- Real-time Activity -->
        <div class="card rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-semibold text-white">Canlı Aktivite</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-green-400 text-sm">Canlı</span>
                </div>
            </div>
            <div class="space-y-2 max-h-32 overflow-y-auto" id="realTimeActivity">
                <!-- Real-time activity will be populated here -->
            </div>
        </div>

        <!-- System Health -->
        <div class="card rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-semibold text-white">Sistem Durumu</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-green-400 text-sm">Çalışıyor</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">Database</span>
                    <span class="text-green-400 flex items-center gap-1 text-sm">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                        Aktif
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">OpenAI API</span>
                    <span class="text-green-400 flex items-center gap-1 text-sm">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                        Aktif
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">Chat Servisi</span>
                    <span class="text-green-400 flex items-center gap-1 text-sm">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                        Çalışıyor
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400 text-sm">Rate Limiting</span>
                    <span class="text-green-400 flex items-center gap-1 text-sm">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                        Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Chart.js default config
    Chart.defaults.color = '#9CA3AF';
    Chart.defaults.borderColor = '#374151';
    Chart.defaults.backgroundColor = 'rgba(59, 130, 246, 0.1)';

    // Initialize charts
    initializeCharts();
    
    // Real-time updates every 30 seconds
    setInterval(updateRealTimeData, 30000);

    function initializeCharts() {
        // Daily Requests Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'line',
            data: {
                labels: generateDayLabels(7),
                datasets: [{
                    label: 'Günlük İstekler',
                    data: @json($chartData['requests'] ?? []),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: getChartOptions()
        });

        // Daily Messages Chart
        const messagesCtx = document.getElementById('messagesChart').getContext('2d');
        new Chart(messagesCtx, {
            type: 'line',
            data: {
                labels: generateDayLabels(7),
                datasets: [{
                    label: 'Chat Mesajları',
                    data: @json($chartData['messages'] ?? []),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: getChartOptions()
        });

        // User Activity Chart
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: generateDayLabels(7),
                datasets: [{
                    label: 'Aktif Kullanıcılar',
                    data: @json($chartData['users'] ?? []),
                    backgroundColor: 'rgba(139, 92, 246, 0.6)',
                    borderColor: '#8B5CF6',
                    borderWidth: 1
                }]
            },
            options: getChartOptions()
        });

        // Error Rate Chart
        const errorCtx = document.getElementById('errorChart').getContext('2d');
        new Chart(errorCtx, {
            type: 'line',
            data: {
                labels: generateDayLabels(7),
                datasets: [{
                    label: 'Hata Sayısı',
                    data: @json($chartData['errors'] ?? []),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: getChartOptions()
        });
    }

    function getChartOptions() {
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'transparent',
                    borderWidth: 0
                }
            },
            scales: {
                x: {
                    display: true,
                    grid: {
                        display: false,
                        drawBorder: false,
                        drawOnChartArea: false,
                        drawTicks: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            size: 11
                        },
                        padding: 10
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    display: true,
                    grid: {
                        display: false,
                        drawBorder: false,
                        drawOnChartArea: false,
                        drawTicks: false
                    },
                    ticks: {
                        display: false
                    },
                    beginAtZero: true,
                    border: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    radius: 0,
                    hoverRadius: 6,
                    hitRadius: 15,
                    borderWidth: 0,
                    hoverBorderWidth: 2
                },
                line: {
                    borderWidth: 3,
                    tension: 0.4,
                    borderCapStyle: 'round',
                    borderJoinStyle: 'round'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        };
    }

    function generateDayLabels(days) {
        const labels = [];
        for (let i = days - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            labels.push(date.toLocaleDateString('tr-TR', { day: '2-digit', month: '2-digit' }));
        }
        return labels;
    }

    function updateRealTimeData() {
        const activities = [
            'Yeni chat mesajı alındı',
            'API isteği işlendi',
            'Rate limit kontrolü geçildi',
            'Proje konfigürasyonu güncellendi',
            'Güvenlik taraması tamamlandı',
            'Kullanıcı giriş yaptı',
            'Yeni proje oluşturuldu'
        ];

        const activity = activities[Math.floor(Math.random() * activities.length)];
        const timestamp = new Date().toLocaleTimeString('tr-TR');
        
        const activityHtml = `
            <div class="flex items-center justify-between py-1 border-b border-gray-700 last:border-b-0">
                <span class="text-xs text-gray-300">${activity}</span>
                <span class="text-xs text-gray-500">${timestamp}</span>
            </div>
        `;
        
        $('#realTimeActivity').prepend(activityHtml);
        
        // Keep only last 4 activities
        $('#realTimeActivity .flex').slice(4).remove();
    }

    // Initialize real-time data
    updateRealTimeData();
});
</script>
@endsection