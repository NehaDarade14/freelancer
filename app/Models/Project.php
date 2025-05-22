<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fickrr\User;

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
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}