<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function storeReview(Request $request, string $slug): RedirectResponse
    {
        $website = Website::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'author_name'  => ['required', 'string', 'max:100'],
            'author_email' => ['nullable', 'email', 'max:150'],
            'author_role'  => ['nullable', 'string', 'max:100'],
            'rating'       => ['required', 'integer', 'min:1', 'max:5'],
            'content'      => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        Testimonial::create([
            'website_id'   => $website->id,
            'author_name'  => $data['author_name'],
            'author_email' => $data['author_email'] ?? null,
            'author_role'  => $data['author_role'] ?? null,
            'rating'       => $data['rating'],
            'content'      => $data['content'],
            'status'       => 'pending',
            'reviewed_at'  => now(),
        ]);

        return redirect()
            ->route('public.profile', $slug)
            ->with('review_submitted', true);
    }
}

