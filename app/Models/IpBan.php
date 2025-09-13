<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpBan extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'type',
        'reason',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function isActive(): bool
    {
        if ($this->type === 'permanent') {
            return true;
        }

        return $this->expires_at && $this->expires_at->isFuture();
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('type', 'permanent')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('type', 'temporary')
                     ->where('expires_at', '<=', now());
    }
}
