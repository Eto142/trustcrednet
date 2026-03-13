<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    public function show(string $slug): View
    {
        $website = Website::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'user',
                'approvedTestimonials' => fn ($q) => $q->orderByRaw(
                    'COALESCE(reviewed_at, created_at) DESC'
                ),
            ])
            ->firstOrFail();

        $reviews    = $website->approvedTestimonials;
        $avgRating  = $reviews->avg('rating');
        $total      = $reviews->count();
        $counts     = $reviews->groupBy('rating')->map->count();

        return view('public.profile', compact('website', 'avgRating', 'total', 'counts'));
    }
}
