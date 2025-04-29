<?php

namespace Fickrr\Http\Controllers\Admin;

use Fickrr\Http\Controllers\Controller;
use Fickrr\Models\Users;
use Fickrr\Models\Members;
use Illuminate\Http\Request;

class AdminKycController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Members::getKycUsers();
        return view('admin.kyc.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Users::where('id',$id)->first();
        return view('admin.kyc.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function approve(Users $user)
    {
        $user->update(['kyc_status' => 'approved']);
        return redirect()->route('admin.kyc.index')->with('success', 'KYC approved successfully');
    }

    public function reject(Users $user)
    {
        $user->update(['kyc_status' => 'rejected']);
        return redirect()->route('admin.kyc.index')->with('success', 'KYC rejected successfully');
    }

    public function destroy(Users $user)
    {
        //
    }
}
