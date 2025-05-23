<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'subject', 
        'message',
        'status',
        'priority',
        'admin_response'
    ];

    protected $casts = [
        'status' => 'string',
        'priority' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
