<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bid_pack_type_id',
        'remaining_bids',
        'expires_at'
    ];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidPackType()
    {
        return $this->belongsTo(BidPackType::class);
    }

    public function scopeValid($query)
    {
        return $query->where('remaining_bids', '>', 0)
            ->where('expires_at', '>', now());
    }
}