<?php

namespace Fickrr\Http\Controllers\Admin;

use Fickrr\Http\Controllers\Controller; 
use Fickrr\Models\BidPackType;
use Illuminate\Http\Request;

class BidPackController extends Controller
{
    public function index()
    {
        $bidPacks = BidPackType::all();
        return view('admin.bid-packs.index', compact('bidPacks'));
    }

    public function create()
    {
        return view('admin.bid-packs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bids_allowed' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'expiration_rules' => 'required|in:monthly,unlimited',
            'is_active' => 'sometimes|boolean'
        ]);

        BidPackType::create($validated);
        return redirect()->route('admin.bid-packs.index')
            ->with('success', 'Bid pack created successfully');
    }

    public function edit(BidPackType $bidPack)
    {
        return view('admin.bid-packs.edit', compact('bidPack'));
    }

    public function update(Request $request, BidPackType $bidPack)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bids_allowed' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'expiration_rules' => 'required|in:monthly,unlimited',
            'is_active' => 'sometimes|boolean'
        ]);

        $bidPack->update($validated);
        return redirect()->route('admin.bid-packs.index')
            ->with('success', 'Bid pack updated successfully');
    }

    public function destroy(BidPackType $bidPack)
    {
        $bidPack->delete();
        return redirect()->route('admin.bid-packs.index')
            ->with('success', 'Bid pack deleted successfully');
    }
}