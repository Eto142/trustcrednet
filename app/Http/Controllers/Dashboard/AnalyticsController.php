<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Placeholder stats — replace with real tracking data in the future
        $stats = [
            'page_views'       => 0,
            'widget_clicks'    => 0,
            'search_queries'   => 0,
            'approved_reviews' => Testimonial::forUser($user->id)->where('status', 'approved')->count(),
        ];

        return view('dashboard.analytics.index', compact('stats'));
    }
}
