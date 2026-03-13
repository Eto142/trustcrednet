<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function index(): View
    {
        $websites = Auth::user()->websites()->withCount('testimonials')->latest()->paginate(15);
        return view('dashboard.websites.index', compact('websites'));
    }

    public function create(): View
    {
        return view('dashboard.websites.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'url'         => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->websites()->create([
            'name'        => $data['name'],
            'slug'        => Website::generateUniqueSlug($data['name']),
            'url'         => $data['url'],
            'description' => $data['description'] ?? null,
            'is_active'   => false,
        ]);

        return redirect()->route('dashboard.websites.index')
            ->with('success', 'Website added! It will be visible once approved by an admin.');
    }

    public function edit(Website $website): View
    {
        $this->authorise($website);
        return view('dashboard.websites.edit', compact('website'));
    }

    public function update(Request $request, Website $website): RedirectResponse
    {
        $this->authorise($website);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'url'         => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $website->update([
            'name'        => $data['name'],
            'url'         => $data['url'],
            'description' => $data['description'] ?? null,
            'slug'        => $website->name !== $data['name']
                                 ? Website::generateUniqueSlug($data['name'], $website->id)
                                 : $website->slug,
        ]);

        return redirect()->route('dashboard.websites.index')
            ->with('success', 'Website updated successfully.');
    }

    public function destroy(Website $website): RedirectResponse
    {
        $this->authorise($website);
        $website->delete();

        return redirect()->route('dashboard.websites.index')
            ->with('success', 'Website removed.');
    }

    private function authorise(Website $website): void
    {
        abort_unless($website->user_id === Auth::id(), 403);
    }
}
