<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_key',
        'gemini_key',
        'max_token',
        'max_tokens_limit',
        'image',
        'logo',
        'temperature',
        'description',
        'instructions',
        'model',
        'is_active',
        'user_id',
        'enable_fallback',
        'fallback_order',
    ];

    protected $casts = [
        'max_token' => 'integer',
        'max_tokens_limit' => 'integer',
        'temperature' => 'float',
        'is_active' => 'boolean',
        'enable_fallback' => 'boolean',
        'fallback_order' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setApiKeyAttribute($value)
    {
        if ($value) {
            $this->attributes['api_key'] = Crypt::encryptString($value);
        }
    }

    public function getApiKeyAttribute($value)
    {
        if (!$value) return null;
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function setGeminiKeyAttribute($value)
    {
        if ($value) {
            $this->attributes['gemini_key'] = Crypt::encryptString($value);
        }
    }

    public function getGeminiKeyAttribute($value)
    {
        if (!$value) return null;
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function getDecryptedApiKey()
    {
        return $this->api_key;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function requestLogs()
    {
        return $this->hasMany(RequestLog::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTotalMessagesAttribute()
    {
        return $this->chatMessages()->count();
    }

    public function getRecentMessagesAttribute()
    {
        return $this->chatMessages()->where('created_at', '>=', now()->subDays(30))->count();
    }

    public function getAvailableModels()
    {
        return [
            'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
            'gpt-4' => 'GPT-4',
            'gpt-4-turbo' => 'GPT-4 Turbo',
            'gemini-pro' => 'Gemini Pro',
            'claude-3-sonnet' => 'Claude 3 Sonnet',
            'claude-3-haiku' => 'Claude 3 Haiku',
        ];
    }

    public function getDefaultFallbackOrder()
    {
        $primary = $this->model;
        $fallbacks = [];
        
        // Primary model'e göre fallback sırası belirle
        switch ($primary) {
            case 'gpt-3.5-turbo':
            case 'gpt-4':
            case 'gpt-4-turbo':
                $fallbacks = ['gemini-pro', 'claude-3-sonnet', 'claude-3-haiku'];
                break;
            case 'gemini-pro':
                $fallbacks = ['gpt-3.5-turbo', 'claude-3-sonnet', 'gpt-4'];
                break;
            case 'claude-3-sonnet':
            case 'claude-3-haiku':
                $fallbacks = ['gpt-3.5-turbo', 'gemini-pro', 'gpt-4'];
                break;
        }
        
        return $fallbacks;
    }

    public function getFallbackOrderAttribute($value)
    {
        if ($value) {
            return json_decode($value, true);
        }
        
        return $this->getDefaultFallbackOrder();
    }
}
