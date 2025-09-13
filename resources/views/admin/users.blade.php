@extends('layouts.admin')

@section('title', 'Kullanıcılar - GlobalGPT Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 border-b border-gray-700 p-6">
    <h1 class="text-xl font-bold text-white mb-2">Kullanıcılar</h1>
    <p class="text-gray-400">Kullanıcıları görüntüleyin ve yönetin</p>
</div>

<!-- Users Content -->
<div class="p-6">
    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Toplam Kullanıcı</div>
                    <div class="text-2xl font-bold text-white" id="totalUsers">0</div>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Aktif Kullanıcı</div>
                    <div class="text-2xl font-bold text-white" id="activeUsers">0</div>
                </div>
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Bu Ay Yeni</div>
                    <div class="text-2xl font-bold text-white" id="newUsers">0</div>
                </div>
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card rounded-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-white">Kullanıcı Listesi</h3>
                <p class="text-gray-400 text-sm">Tüm kayıtlı kullanıcılar ve aktiviteleri</p>
            </div>
            <div class="flex gap-3">
                <div class="relative">
                    <input type="text" id="searchUsers" placeholder="Kullanıcı ara..." class="w-64 px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-user-plus mr-2"></i>
                    Yeni Kullanıcı
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Kullanıcı</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Email</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Kayıt Tarihi</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Son Aktivite</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Mesaj Sayısı</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Durum</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">İşlemler</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <!-- Sample rows - will be replaced by JavaScript -->
                    <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors duration-200">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">JD</span>
                                </div>
                                <div>
                                    <div class="text-white font-medium">John Doe</div>
                                    <div class="text-gray-400 text-sm">ID: #001</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-white">john.doe@example.com</td>
                        <td class="py-3 px-4 text-gray-300">15 Ekim 2024</td>
                        <td class="py-3 px-4 text-gray-300">2 saat önce</td>
                        <td class="py-3 px-4 text-white">142</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                Aktif
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <button class="p-1 text-blue-400 hover:text-blue-300 transition-colors duration-200" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-1 text-gray-400 hover:text-gray-300 transition-colors duration-200" title="Görüntüle">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-1 text-red-400 hover:text-red-300 transition-colors duration-200" title="Sil">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors duration-200">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">JS</span>
                                </div>
                                <div>
                                    <div class="text-white font-medium">Jane Smith</div>
                                    <div class="text-gray-400 text-sm">ID: #002</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-white">jane.smith@example.com</td>
                        <td class="py-3 px-4 text-gray-300">12 Ekim 2024</td>
                        <td class="py-3 px-4 text-gray-300">1 gün önce</td>
                        <td class="py-3 px-4 text-white">89</td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                Beklemede
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <button class="p-1 text-blue-400 hover:text-blue-300 transition-colors duration-200" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-1 text-gray-400 hover:text-gray-300 transition-colors duration-200" title="Görüntüle">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-1 text-red-400 hover:text-red-300 transition-colors duration-200" title="Sil">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-6">
            <div class="text-gray-400 text-sm">
                Toplam <span id="totalUserCount">2</span> kullanıcı gösteriliyor
            </div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition-colors duration-200">
                    <i class="fas fa-chevron-left mr-1"></i>
                    Önceki
                </button>
                <span class="px-3 py-1 bg-blue-600 text-white rounded">1</span>
                <button class="px-3 py-1 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition-colors duration-200">
                    Sonraki
                    <i class="fas fa-chevron-right ml-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- User Detail Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-white">Kullanıcı Detayları</h3>
            <button onclick="closeUserModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="userModalContent">
            <!-- User details will be loaded here -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    loadUsers();
    loadUserStats();
    
    // Search functionality
    $('#searchUsers').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterUsers(searchTerm);
    });
});

function loadUsers() {
    // In real implementation, this would be an AJAX call
    // For now, we'll use the sample data already in the HTML
    
    // Sample implementation:
    /*
    $.ajax({
        url: '/admin/users/list',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                renderUsers(response.data);
            }
        },
        error: function(xhr, status, error) {
            console.error('Users loading error:', error);
        }
    });
    */
}

function loadUserStats() {
    // Sample data - replace with real API call
    $('#totalUsers').text('2');
    $('#activeUsers').text('1');
    $('#newUsers').text('2');
    $('#totalUserCount').text('2');
}

function filterUsers(searchTerm) {
    $('#usersTableBody tr').each(function() {
        const row = $(this);
        const userName = row.find('td:first-child .text-white').text().toLowerCase();
        const userEmail = row.find('td:nth-child(2)').text().toLowerCase();
        
        if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
            row.show();
        } else {
            row.hide();
        }
    });
}

function showUserDetails(userId) {
    // Load user details and show modal
    $('#userModal').removeClass('hidden').addClass('flex');
    
    // Sample user details
    const userDetails = `
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-xl font-medium">JD</span>
                </div>
                <div>
                    <h4 class="text-white font-semibold">John Doe</h4>
                    <p class="text-gray-400">john.doe@example.com</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-700 rounded-lg p-3">
                    <div class="text-gray-400 text-sm">Toplam Mesaj</div>
                    <div class="text-white font-semibold">142</div>
                </div>
                <div class="bg-gray-700 rounded-lg p-3">
                    <div class="text-gray-400 text-sm">Son Aktivite</div>
                    <div class="text-white font-semibold">2 saat önce</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Düzenle
                </button>
                <button class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                    Sil
                </button>
            </div>
        </div>
    `;
    
    $('#userModalContent').html(userDetails);
}

function closeUserModal() {
    $('#userModal').removeClass('flex').addClass('hidden');
}

// Add click handlers to action buttons
$(document).on('click', '.fa-eye', function() {
    const userId = 1; // Get actual user ID from row data
    showUserDetails(userId);
});
</script>
@endsection
