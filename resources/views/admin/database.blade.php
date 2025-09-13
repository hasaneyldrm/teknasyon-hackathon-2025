@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-900 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Database Viewer</h1>
            <p class="text-gray-400">Veritabanı tablolarını görüntüle ve yönet</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Toplam Tablo</p>
                        <p class="text-2xl font-bold text-white" id="total-tables">{{ count($tables) }}</p>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-lg">
                        <i class="fas fa-database text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Chat Mesajları</p>
                        <p class="text-2xl font-bold text-white" id="chat-count">-</p>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-lg">
                        <i class="fas fa-comments text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Aktif Projeler</p>
                        <p class="text-2xl font-bold text-white" id="active-projects">-</p>
                    </div>
                    <div class="bg-purple-500/20 p-3 rounded-lg">
                        <i class="fas fa-project-diagram text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Son 24 Saat</p>
                        <p class="text-2xl font-bold text-white" id="recent-messages">-</p>
                    </div>
                    <div class="bg-orange-500/20 p-3 rounded-lg">
                        <i class="fas fa-clock text-orange-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables List -->
        <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold text-white mb-2">Database Tabloları</h2>
                <p class="text-gray-400">Tablolara tıklayarak içeriğini görüntüleyin</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                @foreach($tables as $table)
                <div class="bg-gray-700 rounded-lg p-4 hover:bg-gray-600 cursor-pointer transition-colors table-card" 
                     data-table="{{ $table['name'] }}">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-white font-semibold">{{ $table['name'] }}</h3>
                        <span class="bg-blue-500/20 text-blue-400 px-2 py-1 rounded text-sm">
                            {{ number_format($table['count']) }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm">{{ $table['description'] }}</p>
                    <div class="mt-3 flex items-center text-gray-500 text-sm">
                        <i class="fas fa-table mr-2"></i>
                        Kayıt sayısı: {{ number_format($table['count']) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Table Data Modal -->
        <div id="table-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-gray-800 rounded-xl max-w-7xl w-full max-h-[90vh] overflow-hidden">
                    <div class="p-6 border-b border-gray-700 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white" id="modal-title">Tablo Verileri</h3>
                            <p class="text-gray-400 text-sm" id="modal-subtitle">Tablo içeriği</p>
                        </div>
                        <button id="close-modal" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 overflow-auto max-h-[70vh]">
                        <div id="table-content">
                            <div class="text-center py-8">
                                <i class="fas fa-spinner fa-spin text-blue-400 text-2xl mb-4"></i>
                                <p class="text-gray-400">Veriler yükleniyor...</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-700 flex items-center justify-between">
                        <div class="text-gray-400 text-sm" id="pagination-info">
                            <!-- Pagination info will be inserted here -->
                        </div>
                        <div class="flex space-x-2" id="pagination-controls">
                            <!-- Pagination controls will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load stats
    loadStats();
    
    // Table card click handlers
    document.querySelectorAll('.table-card').forEach(card => {
        card.addEventListener('click', function() {
            const tableName = this.dataset.table;
            openTableModal(tableName);
        });
    });

    // Modal close
    document.getElementById('close-modal').addEventListener('click', closeTableModal);
    document.getElementById('table-modal').addEventListener('click', function(e) {
        if (e.target === this) closeTableModal();
    });
});

function loadStats() {
    fetch('/admin/database/stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('chat-count').textContent = data.chat_messages?.toLocaleString() || '0';
            document.getElementById('active-projects').textContent = data.active_projects?.toLocaleString() || '0';
            document.getElementById('recent-messages').textContent = data.recent_messages?.toLocaleString() || '0';
        })
        .catch(error => console.error('Stats yüklenirken hata:', error));
}

function openTableModal(tableName) {
    document.getElementById('modal-title').textContent = tableName.toUpperCase();
    document.getElementById('modal-subtitle').textContent = `${tableName} tablosu verileri`;
    document.getElementById('table-modal').classList.remove('hidden');
    loadTableData(tableName);
}

function closeTableModal() {
    document.getElementById('table-modal').classList.add('hidden');
}

function loadTableData(tableName, page = 1) {
    const content = document.getElementById('table-content');
    content.innerHTML = `
        <div class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-blue-400 text-2xl mb-4"></i>
            <p class="text-gray-400">Veriler yükleniyor...</p>
        </div>
    `;

    fetch(`/admin/database/table/${tableName}?page=${page}&per_page=20`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                content.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-red-400 text-2xl mb-4"></i>
                        <p class="text-red-400">${data.error}</p>
                    </div>
                `;
                return;
            }

            renderTableData(data);
        })
        .catch(error => {
            console.error('Tablo verisi yüklenirken hata:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl mb-4"></i>
                    <p class="text-red-400">Veri yüklenirken hata oluştu</p>
                </div>
            `;
        });
}

function renderTableData(data) {
    const content = document.getElementById('table-content');
    
    if (!data.data || data.data.length === 0) {
        content.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-inbox text-gray-400 text-2xl mb-4"></i>
                <p class="text-gray-400">Bu tabloda veri bulunmuyor</p>
            </div>
        `;
        return;
    }

    let tableHtml = `
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-700">
    `;

    // Headers
    data.columns.forEach(column => {
        tableHtml += `<th class="text-left py-3 px-4 text-gray-300 font-medium">${column}</th>`;
    });

    tableHtml += `
                    </tr>
                </thead>
                <tbody>
    `;

    // Rows
    data.data.forEach((row, index) => {
        tableHtml += `<tr class="border-b border-gray-700 hover:bg-gray-700/50">`;
        
        data.columns.forEach(column => {
            let value = row[column];
            if (value === null) value = '<span class="text-gray-500 italic">NULL</span>';
            else if (typeof value === 'string' && value.length > 50) {
                value = value.substring(0, 50) + '...';
            }
            
            tableHtml += `<td class="py-3 px-4 text-gray-300">${value}</td>`;
        });
        
        tableHtml += `</tr>`;
    });

    tableHtml += `
                </tbody>
            </table>
        </div>
    `;

    content.innerHTML = tableHtml;

    // Update pagination
    updatePagination(data);
}

function updatePagination(data) {
    const paginationInfo = document.getElementById('pagination-info');
    const paginationControls = document.getElementById('pagination-controls');

    const start = ((data.current_page - 1) * data.per_page) + 1;
    const end = Math.min(data.current_page * data.per_page, data.total);

    paginationInfo.innerHTML = `${start}-${end} / ${data.total} kayıt gösteriliyor`;

    let controlsHtml = '';
    
    if (data.current_page > 1) {
        controlsHtml += `
            <button onclick="loadTableData('${data.table}', ${data.current_page - 1})" 
                    class="px-3 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                <i class="fas fa-chevron-left"></i>
            </button>
        `;
    }

    controlsHtml += `
        <span class="px-3 py-2 bg-blue-600 text-white rounded">
            ${data.current_page} / ${data.last_page}
        </span>
    `;

    if (data.current_page < data.last_page) {
        controlsHtml += `
            <button onclick="loadTableData('${data.table}', ${data.current_page + 1})" 
                    class="px-3 py-2 bg-gray-700 text-white rounded hover:bg-gray-600">
                <i class="fas fa-chevron-right"></i>
            </button>
        `;
    }

    paginationControls.innerHTML = controlsHtml;
}
</script>
@endsection
