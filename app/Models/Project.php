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
        'image',
        'logo',
        'temperature',
        'description',
        'model',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'max_token' => 'integer',
        'temperature' => 'float',
        'is_active' => 'boolean',
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
}
