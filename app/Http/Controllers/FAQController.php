<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\Http\Controllers\Controller;
use Fickrr\Models\FAQ;


class FAQController extends Controller
{
    /**
     * Display FAQ page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faqs = FAQ::where('is_active', 1)
            ->orderBy('order', 'asc')
            ->get();
            
        return view('pages.faqs', compact('faqs'));
    }
}