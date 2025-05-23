<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fickrr\User;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'freelancer_id',
        'user_id',
        'work_rating',
        'communication_rating',
        'payment_rating',
        'review_text'
    ];

    public static function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'freelancer_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'work_rating' => 'required|integer|between:1,5',
            'communication_rating' => 'required|integer|between:1,5',
            'payment_rating' => 'required|integer|between:1,5',
            'review_text' => 'nullable|string|max:500'
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