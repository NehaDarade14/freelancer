<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'project_updates',
        'messages',
        'payments',
        'new_jobs',
        'application_updates'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getSettings($userId)
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            [
                'project_updates' => true,
                'messages' => true,
                'payments' => true,
                'new_jobs' => true,
                'application_updates' => true
            ]
        );
    }
}