<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;

class MessageNotification extends Model
{
    protected $fillable = [
        'message_id',
        'user_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public static function markMultipleAsRead(array $notificationIds)
    {
        return self::whereIn('id', $notificationIds)
            ->update(['is_read' => true]);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
        return $this;
    }
}