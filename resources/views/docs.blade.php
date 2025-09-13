<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobalGPT API Dokümantasyonu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-top: 2rem;
            margin-bottom: 2rem;
            padding: 2rem;
        }
        .header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .endpoint {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #667eea;
        }
        .method {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.8rem;
            margin-right: 1rem;
        }
        .method.post {
            background: #28a745;
            color: white;
        }
        .method.get {
            background: #007bff;
            color: white;
        }
        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .response-example {
            background: #f1f5f9;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }
        .nav-pills .nav-link.active {
            background-color: #667eea;
        }
        .table th {
            background-color: #667eea;
            color: white;
        }
        .badge-required {
            background-color: #dc3545;
        }
        .badge-optional {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-code"></i> GlobalGPT API</h1>
            <p class="lead mb-0">Güçlü AI Chat API'si - Dokümantasyon</p>
        </div>

        <nav>
            <div class="nav nav-pills justify-content-center mb-4" role="tablist">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#overview" type="button">Genel Bakış</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#authentication" type="button">Kimlik Doğrulama</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#users" type="button">Kullanıcı API</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#chat" type="button">Chat API</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#postman" type="button">Postman</button>
            </div>
        </nav>

        <div class="tab-content">
            <!-- Genel Bakış -->
            <div class="tab-pane fade show active" id="overview">
                <div class="row">
                    <div class="col-12">
                        <h2>🚀 GlobalGPT API'ye Hoş Geldiniz</h2>
                        <p class="lead">GlobalGPT API, güçlü yapay zeka chat özelliklerini uygulamanıza entegre etmenizi sağlar.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5><i class="fas fa-rocket"></i> Özellikler</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success"></i> Kullanıcı yönetimi</li>
                                            <li><i class="fas fa-check text-success"></i> Token tabanlı kimlik doğrulama</li>
                                            <li><i class="fas fa-check text-success"></i> Coin sistemi</li>
                                            <li><i class="fas fa-check text-success"></i> Proje bazlı yapılandırma</li>
                                            <li><i class="fas fa-check text-success"></i> Gerçek zamanlı chat</li>
                                            <li><i class="fas fa-check text-success"></i> Ayrıntılı logging</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h5><i class="fas fa-cogs"></i> Teknik Detaylar</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <li><strong>Base URL:</strong> <code>{{ url('/') }}</code></li>
                                            <li><strong>Format:</strong> JSON</li>
                                            <li><strong>Encoding:</strong> UTF-8</li>
                                            <li><strong>Rate Limit:</strong> 100/dakika</li>
                                            <li><strong>Timeout:</strong> 30 saniye</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kimlik Doğrulama -->
            <div class="tab-pane fade" id="authentication">
                <h2>🔐 Kimlik Doğrulama</h2>
                <p>GlobalGPT API, token tabanlı kimlik doğrulama kullanır. Her kullanıcı kayıt olduktan sonra benzersiz bir token alır.</p>
                
                <div class="alert alert-info">
                    <strong>Önemli:</strong> Token'ınızı güvenli tutun ve asla public repositorylerde paylaşmayın.
                </div>

                <h4>Token Kullanımı</h4>
                <p>API isteklerinde token'ınızı şu şekilde kullanın:</p>
                <div class="code-block">
POST /api/chat
Content-Type: application/json

{
    "message": "Merhaba!",
    "user_token": "your-unique-token-here"
}
                </div>
            </div>

            <!-- Kullanıcı API -->
            <div class="tab-pane fade" id="users">
                <h2>👤 Kullanıcı API</h2>
                
                <!-- Kullanıcı Oluşturma -->
                <div class="endpoint">
                    <h4><span class="method post">POST</span>/api/users</h4>
                    <p>Yeni bir kullanıcı oluşturur ve API token'ı döndürür.</p>
                    
                    <h5>Request Parametreleri</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Parametre</th>
                                <th>Tip</th>
                                <th>Durum</th>
                                <th>Açıklama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>name</code></td>
                                <td>string</td>
                                <td><span class="badge badge-required">Zorunlu</span></td>
                                <td>Kullanıcı adı (max: 255 karakter)</td>
                            </tr>
                            <tr>
                                <td><code>email</code></td>
                                <td>string</td>
                                <td><span class="badge badge-required">Zorunlu</span></td>
                                <td>E-posta adresi (benzersiz olmalı)</td>
                            </tr>
                            <tr>
                                <td><code>password</code></td>
                                <td>string</td>
                                <td><span class="badge badge-required">Zorunlu</span></td>
                                <td>Şifre (min: 8 karakter)</td>
                            </tr>
                            <tr>
                                <td><code>project_id</code></td>
                                <td>integer</td>
                                <td><span class="badge badge-optional">Opsiyonel</span></td>
                                <td>Proje ID (varsayılan: 1)</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5>Örnek İstek</h5>
                    <div class="code-block">
POST {{ url('/api/users') }}
Content-Type: application/json

{
    "name": "Ahmet Yılmaz",
    "email": "ahmet@example.com",
    "password": "güvenli123",
    "project_id": 1
}
                    </div>

                    <h5>Başarılı Yanıt (201)</h5>
                    <div class="response-example">
<pre><code>{
    "success": true,
    "message": "Kullanıcı başarıyla oluşturuldu",
    "data": {
        "id": 15,
        "uuid": "550e8400-e29b-41d4-a716-446655440000",
        "token": "abc123def456ghi789jkl012mno345pqr",
        "name": "Ahmet Yılmaz",
        "email": "ahmet@example.com",
        "coin": 100,
        "project_id": 1,
        "created_at": "2024-01-15T10:30:00.000000Z"
    }
}</code></pre>
                    </div>

                    <h5>Hata Yanıtları</h5>
                    <div class="response-example">
                        <strong>400 - Validation Error:</strong>
<pre><code>{
    "success": false,
    "message": "The email has already been taken."
}</code></pre>
                    </div>
                </div>

                <!-- Kullanıcı Bilgilerini Alma -->
                <div class="endpoint">
                    <h4><span class="method get">GET</span>/api/users/{token}</h4>
                    <p>Token ile kullanıcı bilgilerini getirir.</p>
                    
                    <h5>URL Parametreleri</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Parametre</th>
                                <th>Tip</th>
                                <th>Açıklama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>token</code></td>
                                <td>string</td>
                                <td>Kullanıcının benzersiz token'ı</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5>Örnek İstek</h5>
                    <div class="code-block">
GET {{ url('/api/users/abc123def456ghi789jkl012mno345pqr') }}
                    </div>

                    <h5>Başarılı Yanıt (200)</h5>
                    <div class="response-example">
<pre><code>{
    "success": true,
    "data": {
        "id": 15,
        "uuid": "550e8400-e29b-41d4-a716-446655440000",
        "name": "Ahmet Yılmaz",
        "email": "ahmet@example.com",
        "coin": 95,
        "project_id": 1,
        "project": {
            "id": 1,
            "name": "Default Project",
            "model": "gpt-3.5-turbo"
        },
        "created_at": "2024-01-15T10:30:00.000000Z"
    }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Chat API -->
            <div class="tab-pane fade" id="chat">
                <h2>💬 Chat API</h2>
                
                <div class="endpoint">
                    <h4><span class="method post">POST</span>/api/chat</h4>
                    <p>AI ile sohbet eder ve yanıt alır. Her istek 1 coin harcar.</p>
                    
                    <h5>Request Parametreleri</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Parametre</th>
                                <th>Tip</th>
                                <th>Durum</th>
                                <th>Açıklama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>message</code></td>
                                <td>string</td>
                                <td><span class="badge badge-required">Zorunlu</span></td>
                                <td>Gönderilecek mesaj (max: 1000 karakter)</td>
                            </tr>
                            <tr>
                                <td><code>user_token</code></td>
                                <td>string</td>
                                <td><span class="badge badge-required">Zorunlu</span></td>
                                <td>Kullanıcının benzersiz token'ı</td>
                            </tr>
                            <tr>
                                <td><code>project_id</code></td>
                                <td>integer</td>
                                <td><span class="badge badge-optional">Opsiyonel</span></td>
                                <td>Kullanılacak proje ID</td>
                            </tr>
                            <tr>
                                <td><code>conversation_id</code></td>
                                <td>string</td>
                                <td><span class="badge badge-optional">Opsiyonel</span></td>
                                <td>Konuşma ID (otomatik oluşturulur)</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5>Örnek İstek</h5>
                    <div class="code-block">
POST {{ url('/api/chat') }}
Content-Type: application/json

{
    "message": "Merhaba! Nasılsın?",
    "user_token": "abc123def456ghi789jkl012mno345pqr",
    "project_id": 1
}
                    </div>

                    <h5>Başarılı Yanıt (200)</h5>
                    <div class="response-example">
<pre><code>{
    "success": true,
    "message": "Merhaba! Ben çok iyiyim, teşekkür ederim. Size nasıl yardımcı olabilirim?",
    "data": {
        "conversation_id": "550e8400-e29b-41d4-a716-446655440001",
        "tokens_used": 45,
        "response_time": 1.234,
        "remaining_coins": 94,
        "model": "gpt-3.5-turbo"
    }
}</code></pre>
                    </div>

                    <h5>Hata Yanıtları</h5>
                    <div class="response-example">
                        <strong>401 - Geçersiz Token:</strong>
<pre><code>{
    "success": false,
    "message": "Geçersiz kullanıcı token'ı"
}</code></pre>
                    </div>
                    
                    <div class="response-example">
                        <strong>402 - Yetersiz Coin:</strong>
<pre><code>{
    "success": false,
    "message": "Yetersiz coin bakiyesi"
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Postman -->
            <div class="tab-pane fade" id="postman">
                <h2>📮 Postman ile Test</h2>
                <p>API'yi test etmek için Postman kullanabilirsiniz. Aşağıdaki adımları takip edin:</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5>1. Kullanıcı Oluştur</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Method:</strong> POST</p>
                                <p><strong>URL:</strong> <code>{{ url('/api/users') }}</code></p>
                                <p><strong>Headers:</strong></p>
                                <div class="code-block">
Content-Type: application/json
                                </div>
                                <p><strong>Body (JSON):</strong></p>
                                <div class="code-block">
{
    "name": "Test Kullanıcı",
    "email": "test@example.com",
    "password": "test12345",
    "project_id": 1
}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5>2. Chat Gönder</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Method:</strong> POST</p>
                                <p><strong>URL:</strong> <code>{{ url('/api/chat') }}</code></p>
                                <p><strong>Headers:</strong></p>
                                <div class="code-block">
Content-Type: application/json
                                </div>
                                <p><strong>Body (JSON):</strong></p>
                                <div class="code-block">
{
    "message": "Merhaba AI!",
    "user_token": "BURAYA_TOKEN_YAPISTIRINIZ"
}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <h5><i class="fas fa-exclamation-triangle"></i> Önemli Notlar</h5>
                    <ul class="mb-0">
                        <li>İlk önce kullanıcı oluşturup token alın</li>
                        <li>Token'ı güvenli bir yerde saklayın</li>
                        <li>Her chat isteği 1 coin harcar</li>
                        <li>Coin bittiğinde yeni coin satın almanız gerekir</li>
                        <li>Rate limit: dakikada 100 istek</li>
                    </ul>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h5>Postman Collection</h5>
                    </div>
                    <div class="card-body">
                        <p>Hazır Postman collection'ını indirmek için:</p>
                        <button class="btn btn-info" onclick="downloadPostmanCollection()">
                            <i class="fas fa-download"></i> Postman Collection İndir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">
        
        <div class="text-center">
            <h4>🤝 Destek</h4>
            <p>Sorularınız için bizimle iletişime geçin:</p>
            <p><i class="fas fa-envelope"></i> support@globalgpt.com</p>
            <p><i class="fas fa-globe"></i> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script>
        function downloadPostmanCollection() {
            const collection = {
                "info": {
                    "name": "GlobalGPT API",
                    "description": "GlobalGPT API Collection",
                    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
                },
                "item": [
                    {
                        "name": "Create User",
                        "request": {
                            "method": "POST",
                            "header": [
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                }
                            ],
                            "body": {
                                "mode": "raw",
                                "raw": JSON.stringify({
                                    "name": "Test User",
                                    "email": "test@example.com",
                                    "password": "test12345",
                                    "project_id": 1
                                }, null, 2)
                            },
                            "url": {
                                "raw": "{{ url('/api/users') }}",
                                "protocol": "{{ request()->isSecure() ? 'https' : 'http' }}",
                                "host": ["{{ request()->getHost() }}"],
                                "path": ["api", "users"]
                            }
                        }
                    },
                    {
                        "name": "Get User",
                        "request": {
                            "method": "GET",
                            "url": {
                                "raw": "{{ url('/api/users/YOUR_TOKEN_HERE') }}",
                                "protocol": "{{ request()->isSecure() ? 'https' : 'http' }}",
                                "host": ["{{ request()->getHost() }}"],
                                "path": ["api", "users", "YOUR_TOKEN_HERE"]
                            }
                        }
                    },
                    {
                        "name": "Chat",
                        "request": {
                            "method": "POST",
                            "header": [
                                {
                                    "key": "Content-Type",
                                    "value": "application/json"
                                }
                            ],
                            "body": {
                                "mode": "raw",
                                "raw": JSON.stringify({
                                    "message": "Merhaba AI!",
                                    "user_token": "YOUR_TOKEN_HERE"
                                }, null, 2)
                            },
                            "url": {
                                "raw": "{{ url('/api/chat') }}",
                                "protocol": "{{ request()->isSecure() ? 'https' : 'http' }}",
                                "host": ["{{ request()->getHost() }}"],
                                "path": ["api", "chat"]
                            }
                        }
                    }
                ]
            };

            const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(collection, null, 2));
            const downloadAnchorNode = document.createElement('a');
            downloadAnchorNode.setAttribute("href", dataStr);
            downloadAnchorNode.setAttribute("download", "GlobalGPT_API.postman_collection.json");
            document.body.appendChild(downloadAnchorNode);
            downloadAnchorNode.click();
            downloadAnchorNode.remove();
        }
    </script>
</body>
</html>
