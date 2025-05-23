<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'freelancer_id',
        'user_id',
        'rating',
        'comment'
    ];

    public static function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'freelancer_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}