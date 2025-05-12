<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;
use Fickrr\Models\JobApplication;
use Fickrr\Models\User;

class Message extends Model
{
    protected $fillable = [
        'job_application_id',
        'user_id',
        'content',
        'is_read',
        'notification_sent',
        'read_at'
    ];

    protected $dates = [
        'read_at'
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function user()
    {
        return $this->belongsTo(\Fickrr\User::class);
    }
}
