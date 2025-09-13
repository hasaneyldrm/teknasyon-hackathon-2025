@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-white mb-4">Geçmiş</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-pink-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Toplam Mesaj</h3>
            <p class="text-2xl font-bold">{{ number_format($chatStats['total_messages']) }}</p>
        </div>
        <div class="bg-purple-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Bu Hafta</h3>
            <p class="text-2xl font-bold">{{ number_format($chatStats['this_week_messages']) }}</p>
        </div>
        <div class="bg-green-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Toplam Kullanıcı</h3>
            <p class="text-2xl font-bold">{{ number_format($userStats['total_unique_users']) }}</p>
        </div>
        <div class="bg-yellow-500 rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold">Aktif Proje</h3>
            <p class="text-2xl font-bold">{{ $popularProjects->count() }}</p>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Son 7 Gün Aktivite</h3>
        <div class="space-y-2">
            @foreach($monthlyActivity as $activity)
                <div class="flex justify-between items-center">
                    <span class="text-gray-300">{{ $activity['date'] }}</span>
                    <span class="text-white font-bold">{{ $activity['count'] }} mesaj</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection