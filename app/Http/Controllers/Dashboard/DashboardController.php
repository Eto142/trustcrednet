<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $websiteCount        = $user->websites()->count();
        $totalTestimonials   = Testimonial::forUser($user->id)->count();
        $pendingTestimonials = Testimonial::forUser($user->id)->where('status', 'pending')->count();
        $avgRating           = Testimonial::forUser($user->id)->where('status', 'approved')->avg('rating');
        $recentTestimonials  = Testimonial::forUser($user->id)
            ->with('website')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'user', 'websiteCount', 'totalTestimonials',
            'pendingTestimonials', 'avgRating', 'recentTestimonials'
        ));
    }
}
