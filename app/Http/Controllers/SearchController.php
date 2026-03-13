<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $q = trim($request->query('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $results = Website::query()
            ->where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%')
                      ->orWhere('description', 'like', '%' . $q . '%')
                      ->orWhere('url', 'like', '%' . $q . '%');
            })
            ->with('user:id,name,logo_path')
            ->withCount('approvedTestimonials')
            ->withAvg('approvedTestimonials', 'rating')
            ->orderByDesc('approved_testimonials_count')
            ->limit(6)
            ->get(['id', 'user_id', 'name', 'slug', 'description', 'url'])
            ->map(fn ($w) => [
                'name'   => $w->name,
                'slug'   => $w->slug,
                'url'    => url('/' . $w->slug),
                'logo'   => $w->user?->logo_path,
                'rating' => $w->approved_testimonials_avg_rating
                    ? round($w->approved_testimonials_avg_rating, 1)
                    : null,
                'total'  => $w->approved_testimonials_count,
            ]);

        return response()->json($results);
    }
}
