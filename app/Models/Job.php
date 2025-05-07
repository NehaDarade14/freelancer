<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'job_type',
        'salary',
        'location',
        'deadline',
        'experience_level',
        'skills_required',
        'status',
        'employer_id'
    ];

    protected $casts = [
        'skills_required' => 'array',
        'deadline' => 'datetime'
    ];

    public function employer()
    {
        return $this->belongsTo(Users::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
