<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteApproved;
use App\Models\Website;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        $website->update([
            'is_active'             => true,
            'activated_at'          => now(),
            'activation_expires_at' => now()->addYear(),
        ]);

        Mail::to($website->user->email)->send(new WebsiteApproved($website));

        $this->pingSitemapToGoogle();

        return back()->with('message', 'Website "' . $website->name . '" has been approved and the user has been notified.');
    }

    public function reject(Website $website)
    {
        $website->update([
            'is_active'             => false,
            'activated_at'          => null,
            'activation_expires_at' => null,
        ]);
        return back()->with('message', 'Website "' . $website->name . '" has been rejected.');
    }

    private function pingSitemapToGoogle(): void
    {
        $sitemapUrl = url('/sitemap.xml');

        try {
            Http::timeout(5)->get('https://www.google.com/ping', [
                'sitemap' => $sitemapUrl,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Google sitemap ping failed: ' . $e->getMessage());
        }
    }
}
