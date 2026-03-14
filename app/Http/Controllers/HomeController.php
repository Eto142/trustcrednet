<?php

namespace App\Http\Controllers;

use App\Models\Website;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Website::query()
            ->where('is_active', true)
            ->with('user:id,name,logo_path')
            ->withCount('approvedTestimonials')
            ->withAvg('approvedTestimonials', 'rating')
            ->orderByDesc('approved_testimonials_count')
            ->limit(8)
            ->get(['id', 'user_id', 'name', 'slug', 'description']);

        return view('home.homepage', compact('featured'));
    }
}
