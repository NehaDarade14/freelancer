<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;
use Fickrr\User;

class Notification extends Model
{
    protected $table = 'message_notifications';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'user_id',
        'message_id', 
        'is_read'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}