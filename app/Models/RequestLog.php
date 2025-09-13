<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_uuid',
        'project_id',
        'ip_address',
        'method',
        'path',
        'request_data',
        'response_code',
        'response_data',
        'response_time',
        'user_agent',
        'action',
        'error_message',
        'security_flags',
    ];

    protected $casts = [
        'security_flags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'response_time' => 'integer',
        'response_code' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeByIp($query, $ip)
    {
        return $query->where('ip_address', $ip);
    }

    public function scopeByUser($query, $userUuid)
    {
        return $query->where('user_uuid', $userUuid);
    }

    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    public function scopeErrors($query)
    {
        return $query->where('response_code', '>=', 400);
    }
}
