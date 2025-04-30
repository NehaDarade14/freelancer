<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\BidService;
use Symfony\Component\HttpFoundation\Response;

class CheckBidAvailability
{
    public function __construct(
        protected BidService $bidService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Allow access to these routes without bid check
        $exemptRoutes = ['bid-packs.index', 'logout', 'login'];
        if (in_array($request->route()->getName(), $exemptRoutes)) {
            return $next($request);
        }

        if (!$user) {
            return redirect()->route('login')->with('intended', $request->fullUrl());
        }

        try {
            if ($this->bidService->deductBid($user)) {
                \Log::info("Bid deducted for user {$user->id}");
                return $next($request);
            }
            
            \Log::warning("Insufficient bids for user {$user->id}");
            return redirect()->route('bid-packs.index')
                ->with('bid_redirect', true)
                ->withErrors(['bids' => 'Purchase additional bids to continue']);

        } catch (\Exception $e) {
            \Log::error("Bid check failed: " . $e->getMessage());
            return redirect()->route('bid-packs.index')
                ->withErrors(['bids' => 'Error processing your request']);
        }
    }
}