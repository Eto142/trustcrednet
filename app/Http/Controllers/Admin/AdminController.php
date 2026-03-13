<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function dashboard()
    {
        $totalUsers          = User::count();
        $totalWebsites       = Website::count();
        $totalTestimonials   = Testimonial::count();
        $pendingTestimonials = Testimonial::where('status', 'pending')->count();
        $avgRating           = Testimonial::where('status', 'approved')->avg('rating');
        $recentUsers         = User::withCount('websites')->latest()->take(5)->get();
        $recentTestimonials  = Testimonial::with('website')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalWebsites', 'totalTestimonials',
            'pendingTestimonials', 'avgRating', 'recentUsers', 'recentTestimonials'
        ));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
