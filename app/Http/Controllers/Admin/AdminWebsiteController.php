<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;

class AdminWebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with('user')->withCount('testimonials')->latest()->paginate(20);
        return view('admin.websites', compact('websites'));
    }

    public function approve(Website $website)
    {
        $website->update(['is_active' => true]);
        return back()->with('message', 'Website "' . $website->name . '" has been approved.');
    }

    public function reject(Website $website)
    {
        $website->update(['is_active' => false]);
        return back()->with('message', 'Website "' . $website->name . '" has been rejected.');
    }
}
