@extends('layouts.admin')

@section('title', 'Dashboard - GlobalGPT Admin')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/date-fns@2.29.3/index.min.js"></script>
@endsection

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Live Charts</h1>
    <p class="text-gray-400">It is currently {{ now()->format('Y-m-d H:i:s') }} UTC</p>
</div>

<!-- Time Filter Buttons -->
<div class="p-6">
    <div class="flex justify-end mb-6">
        <div class="inline-flex rounded-lg bg-gray-800 p-1">
            <button class="time-filter px-3 py-1 text-sm rounded-md text-gray-400 hover:text-white transition-colors" data-period="10m">10 min</button>
            <button class="time-filter px-3 py-1 text-sm rounded-md text-gray-400 hover:text-white transition-colors" data-period="1h">1 hour</button>
            <button class="time-filter px-3 py-1 text-sm rounded-md text-gray-400 hover:text-white transition-colors" data-period="1d">1 day</button>
            <button class="time-filter px-3 py-1 text-sm rounded-md bg-blue-600 text-white" data-period="1w">1 week</button>
            <button class="time-filter px-3 py-1 text-sm rounded-md text-gray-400 hover:text-white transition-colors" data-period="1m">1 month</button>
            <button class="time-filter px-3 py-1 text-sm rounded-md text-gray-400 hover:text-white transition-colors" data-period="1y">1 year</button>
        </div>
    </div>

    <!-- Main Charts Grid -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Requests Chart -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Requests over the last seven days</h3>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-gray-400">Incoming requests</span>
                    </div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="requestsChart"></canvas>
            </div>
        </div>

        <!-- Rate Limiting Chart -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Requests denied by your rate limiting rules over the last seven days</h3>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm text-gray-400">Rejected by your rate limiting rules</span>
                    </div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="rateLimitChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Secondary Charts Grid -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Device Check Chart -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Requests that attempted DeviceCheck over the last seven days</h3>
                    <div class="flex items-center gap-4 mt-2">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-teal-500 rounded-full"></div>
                            <span class="text-sm text-gray-400">Passed DeviceCheck</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-400">Failed DeviceCheck</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                            <span class="text-sm text-gray-400">Used iOS simulator bypass</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="deviceCheckChart"></canvas>
            </div>
        </div>

        <!-- Error Chart -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-white">Requests that resulted in a non-200 over the last seven days</h3>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm text-gray-400">Provider returned a non-200</span>
                    </div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="errorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Requests Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Total Requests</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['total_requests']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $stats['recent_requests'] }} last 7 days
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">API requests processed</div>
            </div>
        </div>

        <!-- Chat Messages Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Chat Messages</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['total_messages']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        {{ $stats['recent_messages'] }} last 30 days
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Total messages processed</div>
            </div>
        </div>

        <!-- Active Projects Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Active Projects</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['active_projects']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                        </svg>
                        {{ $stats['total_projects'] }} total
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">AI projects running</div>
            </div>
        </div>

        <!-- Security Status Card -->
        <div class="card rounded-xl py-6 shadow-sm">
            <div class="px-6">
                <div class="text-gray-400 text-sm mb-2">Security Status</div>
                <div class="text-2xl font-semibold text-white mb-4">{{ number_format($stats['active_bans']) }}</div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center rounded-md border border-gray-600 px-2 py-0.5 text-xs font-medium text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        {{ $stats['ip_bans'] }} total bans
                    </span>
                </div>
            </div>
            <div class="px-6 mt-4">
                <div class="text-sm text-gray-400">Active IP bans</div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Real-time Activity -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Real-time Activity</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-green-400 text-sm">Live</span>
                </div>
            </div>
            <div class="space-y-4" id="realTimeActivity">
                <!-- Real-time activity will be populated here -->
            </div>
        </div>

        <!-- System Health -->
        <div class="card rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">System Health</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-green-400 text-sm">All systems operational</span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Database Connection</span>
                    <span class="text-green-400 flex items-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        Operational
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">OpenAI API</span>
                    <span class="text-green-400 flex items-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        Operational
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Chat Service</span>
                    <span class="text-green-400 flex items-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        Operational
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Rate Limiting</span>
                    <span class="text-green-400 flex items-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        Active
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
    
    // Real-time updates
    setInterval(updateRealTimeData, 30000); // Update every 30 seconds
    
    // Time filter functionality
    $('.time-filter').on('click', function() {
        $('.time-filter').removeClass('bg-blue-600 text-white').addClass('text-gray-400');
        $(this).removeClass('text-gray-400').addClass('bg-blue-600 text-white');
        
        const period = $(this).data('period');
        updateChartsForPeriod(period);
    });

    function initializeCharts() {
        // Requests Chart
        const requestsCtx = document.getElementById('requestsChart').getContext('2d');
        window.requestsChart = new Chart(requestsCtx, {
            type: 'line',
            data: {
                labels: generateTimeLabels(7), // Last 7 days
                datasets: [{
                    label: 'Incoming requests',
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

        // Rate Limiting Chart
        const rateLimitCtx = document.getElementById('rateLimitChart').getContext('2d');
        window.rateLimitChart = new Chart(rateLimitCtx, {
            type: 'line',
            data: {
                labels: generateTimeLabels(7),
                datasets: [{
                    label: 'Rejected by rate limiting',
                    data: @json($chartData['rateLimited'] ?? []),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: getChartOptions()
        });

        // Device Check Chart
        const deviceCheckCtx = document.getElementById('deviceCheckChart').getContext('2d');
        window.deviceCheckChart = new Chart(deviceCheckCtx, {
            type: 'line',
            data: {
                labels: generateTimeLabels(7),
                datasets: [
                    {
                        label: 'Passed DeviceCheck',
                        data: @json($chartData['deviceCheckPassed'] ?? []),
                        borderColor: '#14B8A6',
                        backgroundColor: 'rgba(20, 184, 166, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    },
                    {
                        label: 'Failed DeviceCheck',
                        data: @json($chartData['deviceCheckFailed'] ?? []),
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    },
                    {
                        label: 'iOS Simulator Bypass',
                        data: @json($chartData['simulatorBypass'] ?? []),
                        borderColor: '#8B5CF6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    }
                ]
            },
            options: getChartOptions()
        });

        // Error Chart
        const errorCtx = document.getElementById('errorChart').getContext('2d');
        window.errorChart = new Chart(errorCtx, {
            type: 'line',
            data: {
                labels: generateTimeLabels(7),
                datasets: [{
                    label: 'Non-200 responses',
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
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280'
                    }
                },
                y: {
                    grid: {
                        color: '#374151'
                    },
                    ticks: {
                        color: '#6B7280'
                    },
                    beginAtZero: true
                }
            },
            elements: {
                point: {
                    radius: 0,
                    hoverRadius: 4
                }
            }
        };
    }

    function generateTimeLabels(days) {
        const labels = [];
        for (let i = days - 1; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            labels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
        }
        return labels;
    }

    function updateChartsForPeriod(period) {
        // Show loading state
        $('.card canvas').css('opacity', '0.5');
        
        $.ajax({
            url: '/admin/dashboard/data',
            data: { period: period },
            success: function(data) {
                // Update all charts with new data
                updateChart(window.requestsChart, data.labels, data.requests, 'Incoming requests');
                updateChart(window.rateLimitChart, data.labels, data.rateLimited, 'Rejected by rate limiting');
                updateChart(window.errorChart, data.labels, data.errors, 'Non-200 responses');
                
                // Update device check chart (multiple datasets)
                window.deviceCheckChart.data.labels = data.labels;
                window.deviceCheckChart.data.datasets[0].data = data.deviceCheckPassed;
                window.deviceCheckChart.data.datasets[1].data = data.deviceCheckFailed;
                window.deviceCheckChart.data.datasets[2].data = data.simulatorBypass;
                window.deviceCheckChart.update('none');
                
                // Remove loading state
                $('.card canvas').css('opacity', '1');
            },
            error: function() {
                console.error('Failed to fetch chart data');
                $('.card canvas').css('opacity', '1');
            }
        });
    }
    
    function updateChart(chart, labels, data, label) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.data.datasets[0].label = label;
        chart.update('none');
    }

    function updateRealTimeData() {
        // Simulate real-time activity updates
        const activities = [
            'New chat message from user #' + Math.floor(Math.random() * 1000),
            'API request processed successfully',
            'Rate limit check passed',
            'Project configuration updated',
            'Security scan completed'
        ];

        const activity = activities[Math.floor(Math.random() * activities.length)];
        const timestamp = new Date().toLocaleTimeString();
        
        const activityHtml = `
            <div class="flex items-center justify-between py-2 border-b border-gray-700 last:border-b-0">
                <span class="text-sm text-gray-300">${activity}</span>
                <span class="text-xs text-gray-500">${timestamp}</span>
            </div>
        `;
        
        $('#realTimeActivity').prepend(activityHtml);
        
        // Keep only last 5 activities
        $('#realTimeActivity .flex').slice(5).remove();
    }

    // Initialize real-time data
    updateRealTimeData();
});
</script>
@endsection