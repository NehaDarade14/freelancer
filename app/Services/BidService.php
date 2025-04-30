<?php

namespace Fickrr\Services;

use Fickrr\Models\Bid;
use Fickrr\Models\Users;
use Carbon\Carbon;

class BidService
{
    public function deductBid(User $user): bool
    {
        $activeBid = $this->getActiveBid($user);
        
        if (!$activeBid) {
            return false;
        }

        if ($activeBid->bidPackType->is_unlimited) {
            return true;
        }

        $activeBid->decrement('remaining_bids');
        return true;
    }

    public function getActiveBid(User $user): ?Bid
    {
        return $user->bids()
            ->with('bidPackType')
            ->valid()
            ->latest('expires_at')
            ->first();
    }

    public function createMonthlyBidPack(User $user, $bidPackType): void
    {
        $expiresAt = Carbon::now()->endOfMonth();

        $user->bids()->create([
            'bid_pack_type_id' => $bidPackType->id,
            'remaining_bids' => $bidPackType->bid_allowance,
            'expires_at' => $expiresAt
        ]);
    }

    public function resetMonthlyBids(): void
    {
        Bid::whereHas('bidPackType', function ($query) {
            $query->where('expires_month_end', true)
                ->where('is_unlimited', false);
        })->update([
            'remaining_bids' => 0,
            'expires_at' => now()->endOfMonth()
        ]);
    }
}