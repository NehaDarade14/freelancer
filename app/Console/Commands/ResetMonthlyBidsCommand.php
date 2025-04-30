<?php

namespace Fickrr\Console\Commands;

use Illuminate\Console\Command;
use Fickrr\Services\BidService;

class ResetMonthlyBidsCommand extends Command
{
    protected $signature = 'bid:reset-monthly';
    protected $description = 'Reset monthly bid allocations at end of month';

    public function __construct(
        protected BidService $bidService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->bidService->resetMonthlyBids();
        $this->info('Successfully reset monthly bids');
    }
}