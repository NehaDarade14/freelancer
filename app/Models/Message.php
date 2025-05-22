<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Fickrr\User;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'messageable_id',
        'messageable_type',
        'content',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function messageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(MessageNotification::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)
              ->where('receiver_id', $userId2);
        })->orWhere(function($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)
              ->where('receiver_id', $userId1);
        });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('receiver_id', $userId);
    }

    public static function getConversations($userId)
    {
        // Get all unique conversation partners
        $conversationPartners = self::select('sender_id as user_id')
            ->where('receiver_id', $userId)
            ->union(
                self::select('receiver_id as user_id')
                    ->where('sender_id', $userId)
            )
            ->distinct()
            ->pluck('user_id');

        // Return user details with unread counts
        return User::select([
                'users.id as user_id',
                'users.name',
                DB::raw('(SELECT COUNT(*) FROM message_notifications
                         JOIN messages ON message_notifications.message_id = messages.id
                         WHERE message_notifications.user_id = '.$userId.'
                         AND message_notifications.is_read = 0
                         AND ((messages.sender_id = users.id AND messages.receiver_id = '.$userId.')
                              OR (messages.sender_id = '.$userId.' AND messages.receiver_id = users.id))) as unread_count')
            ])
            ->whereIn('users.id', $conversationPartners)
            ->orderByDesc(
                DB::raw('(SELECT MAX(created_at) FROM messages
                         WHERE (sender_id = users.id AND receiver_id = '.$userId.')
                         OR (sender_id = '.$userId.' AND receiver_id = users.id))')
            )
            ->get();
    }
}
