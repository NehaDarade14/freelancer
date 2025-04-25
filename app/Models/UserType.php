<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
