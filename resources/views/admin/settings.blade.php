@extends('layouts.admin')

@section('title', 'Ayarlar')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Ayarlar</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Anasayfa</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Ayarlar</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-success">Başarılı!</h4>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="row g-5 g-xl-10">
                <!-- API Settings -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">API Ayarları</h3>
                                <span class="text-muted fw-semibold fs-7">Yapay zeka API konfigürasyonları</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <form method="POST" action="{{ route('admin.settings.update') }}">
                                @csrf
                                <div class="mb-5">
                                    <label class="form-label">OpenAI Durumu</label>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-{{ $settings['openai_status'] === 'Aktif' ? 'success' : 'danger' }} fs-7">
                                            {{ $settings['openai_status'] }}
                                        </span>
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6 ms-2" data-bs-toggle="tooltip" title="API anahtarı durumu">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Model</label>
                                    <select name="openai_model" class="form-select" data-control="select2">
                                        <option value="gpt-3.5-turbo" {{ $settings['openai_model'] === 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
                                        <option value="gpt-4" {{ $settings['openai_model'] === 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                                        <option value="gpt-4-turbo" {{ $settings['openai_model'] === 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo</option>
                                    </select>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Max Tokens</label>
                                    <input type="number" name="max_tokens" class="form-control" value="{{ $settings['max_tokens'] }}" min="1" max="4096">
                                    <div class="form-text">Maksimum token sayısı (1-4096)</div>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Temperature</label>
                                    <input type="number" name="temperature" class="form-control" value="{{ $settings['temperature'] }}" min="0" max="2" step="0.1">
                                    <div class="form-text">Yaratıcılık seviyesi (0.0-2.0)</div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ki-duotone ki-check fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Kaydet
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- System Settings -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Sistem Ayarları</h3>
                                <span class="text-muted fw-semibold fs-7">Uygulama konfigürasyonları</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-5">
                                <label class="form-label">Uygulama Adı</label>
                                <input type="text" class="form-control" value="{{ $settings['app_name'] }}" readonly>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Ortam</label>
                                <span class="badge badge-{{ $settings['app_env'] === 'production' ? 'success' : 'warning' }} fs-7 ms-2">
                                    {{ $settings['app_env'] }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Debug Modu</label>
                                <span class="badge badge-{{ $settings['app_debug'] ? 'danger' : 'success' }} fs-7 ms-2">
                                    {{ $settings['app_debug'] ? 'Açık' : 'Kapalı' }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Zaman Dilimi</label>
                                <input type="text" class="form-control" value="{{ $settings['app_timezone'] }}" readonly>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Veritabanı</label>
                                <span class="badge badge-primary fs-7 ms-2">{{ strtoupper($settings['database_connection']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Güvenlik Ayarları</h3>
                                <span class="text-muted fw-semibold fs-7">Güvenlik ve koruma ayarları</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-5">
                                <label class="form-label">Oturum Süresi</label>
                                <input type="text" class="form-control" value="{{ $settings['session_lifetime'] }} dakika" readonly>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Rate Limiting</label>
                                <span class="badge badge-{{ $settings['rate_limit_enabled'] ? 'success' : 'danger' }} fs-7 ms-2">
                                    {{ $settings['rate_limit_enabled'] ? 'Aktif' : 'Pasif' }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">IP Yasaklama</label>
                                <span class="badge badge-{{ $settings['ip_ban_enabled'] ? 'success' : 'danger' }} fs-7 ms-2">
                                    {{ $settings['ip_ban_enabled'] ? 'Aktif' : 'Pasif' }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">İstek Loglama</label>
                                <span class="badge badge-{{ $settings['request_logging'] ? 'success' : 'danger' }} fs-7 ms-2">
                                    {{ $settings['request_logging'] ? 'Aktif' : 'Pasif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Settings -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Performans Ayarları</h3>
                                <span class="text-muted fw-semibold fs-7">Sistem performans konfigürasyonları</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-5">
                                <label class="form-label">Cache Driver</label>
                                <span class="badge badge-primary fs-7 ms-2">{{ strtoupper($settings['cache_driver']) }}</span>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Queue Driver</label>
                                <span class="badge badge-primary fs-7 ms-2">{{ strtoupper($settings['queue_driver']) }}</span>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Mail Driver</label>
                                <span class="badge badge-primary fs-7 ms-2">{{ strtoupper($settings['mail_driver']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Logs -->
                <div class="col-12">
                    <div class="card card-flush">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <h3 class="fw-bold text-gray-900">Son Sistem Aktiviteleri</h3>
                                <span class="text-muted fw-semibold fs-7">Son {{ $systemLogs->count() }} sistem logu</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800">
                                            <th>Zaman</th>
                                            <th>IP</th>
                                            <th>Method</th>
                                            <th>URL</th>
                                            <th>Durum</th>
                                            <th>Süre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($systemLogs as $log)
                                            <tr>
                                                <td>
                                                    <div class="text-gray-800 fw-bold">{{ $log->created_at->format('H:i:s') }}</div>
                                                    <div class="text-muted fs-7">{{ $log->created_at->format('d.m.Y') }}</div>
                                                </td>
                                                <td class="text-gray-600">{{ $log->ip_address }}</td>
                                                <td>
                                                    <span class="badge badge-light-primary fs-7">{{ $log->method }}</span>
                                                </td>
                                                <td class="text-gray-600 text-truncate" style="max-width: 200px;">{{ $log->url }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $log->response_code >= 200 && $log->response_code < 300 ? 'success' : ($log->response_code >= 400 ? 'danger' : 'warning') }} fs-7">
                                                        {{ $log->response_code }}
                                                    </span>
                                                </td>
                                                <td class="text-gray-600">{{ $log->response_time }}ms</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-10">
                                                    <i class="ki-duotone ki-information-5 fs-3x text-primary mb-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                    <div class="fw-semibold">Henüz sistem logu bulunmuyor</div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
