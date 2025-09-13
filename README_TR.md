# GlobalGPT - AI Sohbet Asistanı

GlobalGPT, OpenAI GPT modelleri kullanarak geliştirilmiş modern bir web tabanlı sohbet asistanıdır. Laravel framework'ü ile oluşturulmuş bu proje, kullanıcıların AI ile etkileşim kurmasını sağlayan güvenli ve kullanıcı dostu bir arayüz sunar.

## 🚀 Özellikler

- **Modern Web Arayüzü**: Responsive ve kullanıcı dostu tasarım
- **OpenAI GPT Entegrasyonu**: GPT-3.5-turbo modeli ile güçlendirilmiş
- **Gerçek Zamanlı Sohbet**: AJAX tabanlı anlık mesajlaşma
- **Türkçe Destek**: Tam Türkçe dil desteği
- **Güvenli**: CSRF koruması ve input validasyonu
- **Responsive Tasarım**: Mobil ve masaüstü uyumlu

## 📋 Gereksinimler

- PHP 8.1 veya üzeri
- Composer
- Laravel 11.x
- OpenAI API Key

## 🛠️ Kurulum

### 1. Projeyi İndirin
```bash
git clone <your-repository-url>
cd globalgpt
```

### 2. Bağımlılıkları Yükleyin
```bash
composer install
```

### 3. Çevresel Değişkenleri Ayarlayın
```bash
cp .env.example .env
php artisan key:generate
```

### 4. OpenAI API Key'ini Ekleyin
`.env` dosyasını açın ve OpenAI API key'inizi ekleyin:
```env
OPENAI_API_KEY=your_openai_api_key_here
```

### 5. Veritabanını Hazırlayın
```bash
php artisan migrate
```

### 6. Sunucuyu Başlatın
```bash
php artisan serve
```

Tarayıcınızda `http://localhost:8000` adresine giderek uygulamayı kullanmaya başlayabilirsiniz.

## 🔧 Yapılandırma

### OpenAI API Key Alma

1. [OpenAI Platform](https://platform.openai.com/) hesabınıza giriş yapın
2. API Keys bölümüne gidin
3. Yeni bir API key oluşturun
4. Bu key'i `.env` dosyasındaki `OPENAI_API_KEY` değişkenine ekleyin

### Model Ayarları

Varsayılan olarak `gpt-3.5-turbo` modeli kullanılmaktadır. Farklı bir model kullanmak istiyorsanız, `app/Http/Controllers/ChatController.php` dosyasındaki model parametresini değiştirebilirsiniz:

```php
'model' => 'gpt-4', // veya başka bir model
```

## 📁 Proje Yapısı

```
globalgpt/
├── app/
│   └── Http/
│       └── Controllers/
│           └── ChatController.php    # Ana sohbet kontrolcüsü
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php        # Ana layout
│       └── chat/
│           └── index.blade.php      # Sohbet sayfası
├── routes/
│   └── web.php                      # Web rotaları
├── config/
│   └── services.php                 # Servis yapılandırmaları
└── .env                             # Çevresel değişkenler
```

## 🎨 Özelleştirme

### Tema Değiştirme
`resources/views/layouts/app.blade.php` dosyasındaki CSS stillerini düzenleyerek tema renklerini değiştirebilirsiniz.

### Sistem Mesajı
ChatController'daki sistem mesajını düzenleyerek AI'nın davranışını özelleştirebilirsiniz:

```php
'content' => 'Sen yardımcı bir AI asistanısın. Türkçe konuş ve kullanıcılara yardımcı ol.'
```

## 🔒 Güvenlik

- CSRF token koruması aktif
- Input validasyonu mevcut
- API key'ler çevresel değişkenlerde saklanıyor
- Rate limiting önerisi (production için)

## 🚀 Production Dağıtımı

Production ortamında kullanım için:

1. `APP_DEBUG=false` yapın
2. `APP_ENV=production` ayarlayın
3. Web sunucusu yapılandırması yapın (Apache/Nginx)
4. HTTPS kullanın
5. Rate limiting ekleyin
6. Log monitoring kurun

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit yapın (`git commit -m 'Add some amazing feature'`)
4. Branch'i push edin (`git push origin feature/amazing-feature`)
5. Pull Request açın

## 📞 İletişim

Sorularınız için issue açabilir veya e-posta gönderebilirsiniz.

## 🎯 Gelecek Özellikler

- [ ] Sohbet geçmişi kaydetme
- [ ] Kullanıcı hesapları
- [ ] Farklı AI modelleri seçimi
- [ ] Dosya yükleme desteği
- [ ] Ses tanıma özelliği
- [ ] Multi-language desteği

---

**GlobalGPT** ile AI'nın gücünü keşfedin! 🚀

