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
        'max_token',
        'image',
        'temperature',
        'description',
        'model',
        'is_active',
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
        $this->attributes['api_key'] = Crypt::encryptString($value);
    }

    public function getApiKeyAttribute($value)
    {
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
