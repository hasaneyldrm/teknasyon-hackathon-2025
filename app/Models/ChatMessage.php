<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_uuid',
        'message',
        'response',
        'project_id',
        'conversation_id',
        'model',
        'tokens_used',
        'response_time',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tokens_used' => 'integer',
        'response_time' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeByUser($query, $userUuid)
    {
        return $query->where('user_uuid', $userUuid);
    }

    public function scopeByConversation($query, $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
