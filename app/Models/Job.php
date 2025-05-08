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
        return $this->belongsTo(\Fickrr\User::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if ($filters['job_type'] ?? false) {
            $query->where('job_type', $filters['job_type']);
        }

        if ($filters['location'] ?? false) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        if ($filters['experience_level'] ?? false) {
            $query->where('experience_level', $filters['experience_level']);
        }

        return $query;
    }

}
