<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fickrr\User;
use Fickrr\Models\Rating;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'scope',
        'deliverables',
        'requirements',
        'communication_preference',
        'budget',
        'deadline',
        'client_id',
        'freelancer_id',
        'status',
        'progress',
        'completed_at'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function isOverdue()
    {
        return $this->deadline && $this->deadline->isPast() && $this->status !== 'completed';
    }

    public function daysUntilDeadline()
    {
        return $this->deadline ? Carbon::now()->diffInDays($this->deadline, false) : null;
    }

    public function team()
    {
        return $this->belongsTo(\Fickrr\Models\Team::class);
    }

    public function milestones()
    {
        return $this->hasMany(\Fickrr\Models\Milestone::class);
    }


    public function ratings()
    {
        return $this->belongsTo(Rating::class, 'id', 'project_id');
    }
}