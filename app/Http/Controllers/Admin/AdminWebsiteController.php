<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteApproved;
use App\Models\Website;
use Illuminate\Support\Facades\Mail;

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

        Mail::to($website->user->email)->send(new WebsiteApproved($website));

        return back()->with('message', 'Website "' . $website->name . '" has been approved and the user has been notified.');
    }

    public function reject(Website $website)
    {
        $website->update(['is_active' => false]);
        return back()->with('message', 'Website "' . $website->name . '" has been rejected.');
    }
}
