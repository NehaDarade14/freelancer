<?php

namespace Fickrr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPackType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bids_allowed',
        'price',
        'is_active',
        'expiration_rules'
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_unlimited', false);
    }
}