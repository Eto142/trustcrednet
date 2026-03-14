<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $profiles = Website::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $content = view('sitemap', compact('profiles'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
