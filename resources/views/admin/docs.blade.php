@extends('layouts.admin')

@section('title', 'API Dokümantasyonu - GlobalGPT Admin')

@section('content')
<div class="flex-1 p-8 bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">📄 API Dokümantasyonu</h1>
                <p class="text-gray-400">GlobalGPT API'sini kullanmak için gereken tüm bilgiler</p>
            </div>
            <div class="flex gap-3">
                <a href="/docs" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15,3 21,3 21,9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                    Tam Dokümantasyon
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white">Base URL</h3>
            </div>
            <p class="text-gray-400 text-sm mb-2">API'nin temel adresi</p>
            <code class="text-green-400 bg-gray-800 px-2 py-1 rounded text-sm">{{ url('/api') }}</code>
        </div>

        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="M9 12l2 2 4-4"></path>
                        <path d="M21 12c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"></path>
                        <path d="M3 12c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white">Format</h3>
            </div>
            <p class="text-gray-400 text-sm mb-2">Veri formatı</p>
            <code class="text-blue-400 bg-gray-800 px-2 py-1 rounded text-sm">JSON</code>
        </div>

        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 1v6m0 6v6"></path>
                        <path d="m15.5 3.5-3 3-3-3"></path>
                        <path d="m15.5 20.5-3-3-3 3"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white">Rate Limit</h3>
            </div>
            <p class="text-gray-400 text-sm mb-2">İstek limiti</p>
            <code class="text-purple-400 bg-gray-800 px-2 py-1 rounded text-sm">100/dakika</code>
        </div>
    </div>

    <!-- API Endpoints -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- User Create API -->
        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded">POST</span>
                <h3 class="text-xl font-semibold text-white">Kullanıcı Oluştur</h3>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Endpoint:</p>
                <code class="text-green-400 bg-gray-800 px-3 py-2 rounded block text-sm">POST /api/users</code>
            </div>

            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Örnek İstek:</p>
                <div class="bg-gray-800 rounded-lg p-4 text-sm">
                    <pre class="text-gray-300"><code>{
  "name": "Ahmet Yılmaz",
  "email": "ahmet@example.com", 
  "password": "güvenli123",
  "project_id": 1
}</code></pre>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Başarılı Yanıt:</p>
                <div class="bg-gray-800 rounded-lg p-4 text-sm">
                    <pre class="text-gray-300"><code>{
  "success": true,
  "message": "Kullanıcı başarıyla oluşturuldu",
  "data": {
    "token": "abc123...",
    "coin": 100,
    ...
  }
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Chat API -->
        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded">POST</span>
                <h3 class="text-xl font-semibold text-white">Chat Gönder</h3>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Endpoint:</p>
                <code class="text-blue-400 bg-gray-800 px-3 py-2 rounded block text-sm">POST /api/chat</code>
            </div>

            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Örnek İstek:</p>
                <div class="bg-gray-800 rounded-lg p-4 text-sm">
                    <pre class="text-gray-300"><code>{
  "message": "Merhaba AI!",
  "user_token": "abc123...",
  "project_id": 1
}</code></pre>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Başarılı Yanıt:</p>
                <div class="bg-gray-800 rounded-lg p-4 text-sm">
                    <pre class="text-gray-300"><code>{
  "success": true,
  "message": "Merhaba! Size nasıl yardımcı olabilirim?",
  "data": {
    "tokens_used": 45,
    "remaining_coins": 99,
    ...
  }
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Get User API -->
        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded">GET</span>
                <h3 class="text-xl font-semibold text-white">Kullanıcı Bilgileri</h3>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Endpoint:</p>
                <code class="text-indigo-400 bg-gray-800 px-3 py-2 rounded block text-sm">GET /api/users/{token}</code>
            </div>

            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Örnek İstek:</p>
                <div class="bg-gray-800 rounded-lg p-4 text-sm">
                    <pre class="text-gray-300"><code>GET {{ url('/api/users/abc123...') }}</code></pre>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-400 text-sm mb-2">Başarılı Yanıt:</p>
                <div class="bg-gray-800 rounded-lg p-4 text-sm">
                    <pre class="text-gray-300"><code>{
  "success": true,
  "data": {
    "name": "Ahmet Yılmaz",
    "coin": 95,
    "project": {...},
    ...
  }
}</code></pre>
                </div>
            </div>
        </div>

        <!-- Postman Test -->
        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white">Postman Test</h3>
            </div>
            
            <div class="space-y-3">
                <div class="bg-gray-800 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-2">1. Kullanıcı Oluştur</h4>
                    <p class="text-gray-400 text-sm mb-2">POST {{ url('/api/users') }}</p>
                    <p class="text-xs text-gray-500">Body'de name, email, password gönder</p>
                </div>
                
                <div class="bg-gray-800 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-2">2. Token'ı Kaydet</h4>
                    <p class="text-gray-400 text-sm mb-2">Response'dan token'ı al</p>
                    <p class="text-xs text-gray-500">Bu token'ı chat isteklerinde kullanacaksın</p>
                </div>
                
                <div class="bg-gray-800 rounded-lg p-4">
                    <h4 class="text-white font-medium mb-2">3. Chat Gönder</h4>
                    <p class="text-gray-400 text-sm mb-2">POST {{ url('/api/chat') }}</p>
                    <p class="text-xs text-gray-500">Body'de message ve user_token gönder</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Important Notes -->
    <div class="mt-8">
        <div class="card rounded-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                        <path d="m21 16-4 4-4-4"></path>
                        <path d="M17 20V4h-2l-2 2H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white">Önemli Notlar</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-white font-medium mb-2">🔐 Güvenlik</h4>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• Token'ınızı güvenli tutun</li>
                        <li>• Public repositorylerde paylaşmayın</li>
                        <li>• HTTPS kullanın (production'da)</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-medium mb-2">💰 Coin Sistemi</h4>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• Her chat isteği 1 coin harcar</li>
                        <li>• Yeni kullanıcı 100 coin ile başlar</li>
                        <li>• Coin bittiğinde 402 hatası alırsınız</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-medium mb-2">⚡ Rate Limiting</h4>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• Dakikada maksimum 100 istek</li>
                        <li>• Limit aşımında 429 hatası</li>
                        <li>• İstek başlıklarında limit bilgisi</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-medium mb-2">🛠️ Hata Kodları</h4>
                    <ul class="text-gray-400 text-sm space-y-1">
                        <li>• 401: Geçersiz token</li>
                        <li>• 402: Yetersiz coin</li>
                        <li>• 429: Rate limit aşımı</li>
                        <li>• 500: Sunucu hatası</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <div class="card rounded-lg p-6">
            <h3 class="text-white font-semibold mb-2">🤝 Destek Gerekli mi?</h3>
            <p class="text-gray-400 text-sm mb-4">API kullanımında sorun yaşıyorsanız bizimle iletişime geçin</p>
            <div class="flex justify-center gap-4">
                <a href="mailto:support@globalgpt.com" class="text-blue-400 hover:text-blue-300 text-sm">
                    📧 support@globalgpt.com
                </a>
                <a href="/docs" target="_blank" class="text-blue-400 hover:text-blue-300 text-sm">
                    📚 Detaylı Dokümantasyon
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
