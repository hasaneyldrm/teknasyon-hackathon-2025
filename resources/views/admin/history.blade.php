@extends('layouts.admin')

@section('title', 'Geçmiş')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Geçmiş</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Anasayfa</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Geçmiş</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Chat Statistics -->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($chatStats['total_messages']) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Toplam Mesaj</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>Bugün: {{ number_format($chatStats['today_messages']) }}</span>
                                    <span>Ortalama: {{ $chatStats['avg_messages_per_day'] }}/gün</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #7239EA;background-image:url('assets/media/patterns/vector-1.png')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($chatStats['this_week_messages']) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Bu Hafta</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>Bu Ay: {{ number_format($chatStats['this_month_messages']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #17C653;background-image:url('assets/media/patterns/vector-1.png')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ number_format($userStats['total_unique_users']) }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Toplam Kullanıcı</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>Bugün: {{ number_format($userStats['active_users_today']) }}</span>
                                    <span>Hafta: {{ number_format($userStats['active_users_week']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #FFC700;background-image:url('assets/media/patterns/vector-1.png')">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $popularProjects->count() }}</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Aktif Proje</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end pt-0">
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                    <span>En Popüler: {{ $popularProjects->first()->name ?? 'Yok' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-10">
                <!-- Monthly Activity Chart -->
                <div class="col-xl-8">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Son 30 Gün Aktivite</h3>
                                <span class="text-muted fw-semibold fs-7">Günlük mesaj sayıları</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <canvas id="monthlyActivityChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Popular Projects -->
                <div class="col-xl-4">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Popüler Projeler</h3>
                                <span class="text-muted fw-semibold fs-7">Mesaj sayısına göre</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            @forelse($popularProjects as $project)
                                <div class="d-flex align-items-center border-1 border-gray-300 border-dashed rounded px-7 py-3 mb-3">
                                    <div class="symbol symbol-50px me-5">
                                        @if($project->logo)
                                            <img src="{{ asset($project->logo) }}" alt="{{ $project->name }}" class="symbol-label">
                                        @else
                                            <div class="symbol-label bg-light-primary">
                                                <i class="ki-duotone ki-abstract-26 fs-2x text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">{{ $project->name }}</a>
                                        <span class="text-muted fw-semibold d-block">{{ $project->chat_messages_count }} mesaj</span>
                                    </div>
                                    <span class="badge badge-light-success fs-8">{{ $project->model }}</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-10">
                                    <i class="ki-duotone ki-information-5 fs-3x text-primary mb-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="fw-semibold">Henüz proje bulunmuyor</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Chats -->
                <div class="col-xl-8">
                    <div class="card card-flush">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Son Chat Mesajları</h3>
                                <span class="text-muted fw-semibold fs-7">Son {{ $recentChats->count() }} mesaj</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800">
                                            <th>Zaman</th>
                                            <th>Kullanıcı</th>
                                            <th>Proje</th>
                                            <th>Mesaj</th>
                                            <th>Tip</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentChats as $chat)
                                            <tr>
                                                <td>
                                                    <div class="text-gray-800 fw-bold">{{ $chat->created_at->format('H:i') }}</div>
                                                    <div class="text-muted fs-7">{{ $chat->created_at->format('d.m.Y') }}</div>
                                                </td>
                                                <td class="text-gray-600">{{ substr($chat->user_uuid, 0, 8) }}...</td>
                                                <td>
                                                    @if($chat->project)
                                                        <span class="badge badge-light-primary fs-7">{{ $chat->project->name }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-gray-600 text-truncate" style="max-width: 300px;">{{ $chat->message }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $chat->type === 'user' ? 'light-info' : 'light-success' }} fs-7">
                                                        {{ $chat->type === 'user' ? 'Kullanıcı' : 'AI' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-10">
                                                    <i class="ki-duotone ki-information-5 fs-3x text-primary mb-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                    <div class="fw-semibold">Henüz chat mesajı bulunmuyor</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Activity -->
                <div class="col-xl-4">
                    <div class="card card-flush">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Sistem Aktivitesi</h3>
                                <span class="text-muted fw-semibold fs-7">Son sistem logları</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="timeline-label">
                                @forelse($systemActivity->take(20) as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $activity->created_at->format('H:i') }}</div>
                                        <div class="timeline-badge">
                                            <i class="ki-duotone ki-abstract-8 text-{{ $activity->response_code >= 200 && $activity->response_code < 300 ? 'success' : 'danger' }} fs-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="fw-semibold timeline-content text-muted ps-3">
                                            <div class="text-gray-800">{{ $activity->method }} {{ $activity->url }}</div>
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="badge badge-secondary fs-8 me-2">{{ $activity->response_code }}</span>
                                                <span class="fs-7 text-muted">{{ $activity->response_time }}ms</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-10">
                                        <i class="ki-duotone ki-information-5 fs-3x text-primary mb-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="fw-semibold">Henüz sistem aktivitesi bulunmuyor</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Activity Chart
    const ctx = document.getElementById('monthlyActivityChart').getContext('2d');
    const monthlyData = @json($monthlyActivity);
    
    const labels = monthlyData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('tr-TR', { day: 'numeric', month: 'short' });
    });
    
    const data = monthlyData.map(item => item.count);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Mesaj Sayısı',
                data: data,
                borderColor: '#1B84FF',
                backgroundColor: 'rgba(27, 132, 255, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1B84FF',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#A1A5B7'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: '#A1A5B7'
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#1B84FF'
                }
            }
        }
    });
});
</script>
@endpush
