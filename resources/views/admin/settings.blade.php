@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-white mb-4">Ayarlar</h1>
    
    <div class="bg-gray-800 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-white mb-4">API Ayarları</h3>
        <p class="text-gray-300">OpenAI Durumu: <span class="text-green-400">{{ $settings['openai_status'] }}</span></p>
        <p class="text-gray-300">Model: <span class="text-blue-400">{{ $settings['openai_model'] }}</span></p>
        <p class="text-gray-300">Max Tokens: <span class="text-yellow-400">{{ $settings['max_tokens'] }}</span></p>
        <p class="text-gray-300">Temperature: <span class="text-purple-400">{{ $settings['temperature'] }}</span></p>
    </div>

    <div class="bg-gray-800 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Sistem Ayarları</h3>
        <p class="text-gray-300">Uygulama: <span class="text-green-400">{{ $settings['app_name'] }}</span></p>
        <p class="text-gray-300">Ortam: <span class="text-blue-400">{{ $settings['app_env'] }}</span></p>
        <p class="text-gray-300">Veritabanı: <span class="text-yellow-400">{{ $settings['database_connection'] }}</span></p>
    </div>
</div>
@endsection