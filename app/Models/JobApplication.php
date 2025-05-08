<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'freelancer_id',
        'proposal',
        'bid_amount',
        'status',
        'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
        'bid_amount' => 'float'
    ];

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getAttachmentsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function getAttachmentsUrlsAttribute()
    {
        if (empty($this->attachments)) {
            return [];
        }

        $flatAttachments = Arr::flatten($this->attachments);

        return array_map(function ($path) {
            return asset('storage/' . ltrim($path, '/'));
        }, $flatAttachments);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
