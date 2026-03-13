<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'all');
        $query  = Testimonial::forUser(Auth::id())->with('website')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $testimonials = $query->paginate(15)->withQueryString();

        $counts = [
            'all'      => Testimonial::forUser(Auth::id())->count(),
            'pending'  => Testimonial::forUser(Auth::id())->where('status', 'pending')->count(),
            'approved' => Testimonial::forUser(Auth::id())->where('status', 'approved')->count(),
            'rejected' => Testimonial::forUser(Auth::id())->where('status', 'rejected')->count(),
        ];

        return view('dashboard.testimonials.index', compact('testimonials', 'status', 'counts'));
    }

    public function create(): View
    {
        $websites = Auth::user()->websites()->where('is_active', true)->get();
        return view('dashboard.testimonials.create', compact('websites'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'website_id'     => ['required', 'integer'],
            'author_name'    => ['required', 'string', 'max:255'],
            'author_email'   => ['nullable', 'email', 'max:255'],
            'author_role'    => ['nullable', 'string', 'max:255'],
            'content'        => ['required', 'string', 'max:2000'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'reviewed_at'    => ['nullable', 'date'],
            'customer_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_featured'    => ['nullable', 'boolean'],
        ]);

        // Ensure the website belongs to this user
        $website = Auth::user()->websites()->findOrFail($data['website_id']);

        $imagePath = null;
        if ($request->hasFile('customer_image')) {
            $disk      = Storage::disk('cloudinary');
            $path      = $disk->putFile('trustcrednet/testimonials', $request->file('customer_image'));
            $imagePath = $disk->url($path);
        }

        $website->testimonials()->create([
            'author_name'    => $data['author_name'],
            'author_email'   => $data['author_email'] ?? null,
            'author_role'    => $data['author_role'] ?? null,
            'customer_image' => $imagePath,
            'reviewed_at'    => $data['reviewed_at'] ?? now()->toDateString(),
            'content'        => $data['content'],
            'rating'         => $data['rating'],
            'status'         => 'approved',
            'is_featured'    => $request->boolean('is_featured'),
        ]);

        return redirect()->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial added successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        $this->authorise($testimonial);
        $websites = Auth::user()->websites()->where('is_active', true)->get();
        return view('dashboard.testimonials.edit', compact('testimonial', 'websites'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $this->authorise($testimonial);

        $data = $request->validate([
            'website_id'     => ['required', 'integer'],
            'author_name'    => ['required', 'string', 'max:255'],
            'author_email'   => ['nullable', 'email', 'max:255'],
            'author_role'    => ['nullable', 'string', 'max:255'],
            'content'        => ['required', 'string', 'max:2000'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'reviewed_at'    => ['nullable', 'date'],
            'customer_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'         => ['required', 'in:approved,pending,rejected'],
            'is_featured'    => ['nullable', 'boolean'],
        ]);

        Auth::user()->websites()->findOrFail($data['website_id']);

        $imagePath = $testimonial->customer_image;
        if ($request->hasFile('customer_image')) {
            $disk      = Storage::disk('cloudinary');
            $path      = $disk->putFile('trustcrednet/testimonials', $request->file('customer_image'));
            $imagePath = $disk->url($path);
        }

        $testimonial->update([
            'website_id'     => $data['website_id'],
            'author_name'    => $data['author_name'],
            'author_email'   => $data['author_email'] ?? null,
            'author_role'    => $data['author_role'] ?? null,
            'customer_image' => $imagePath,
            'reviewed_at'    => $data['reviewed_at'] ?? $testimonial->reviewed_at,
            'content'        => $data['content'],
            'rating'         => $data['rating'],
            'status'         => $data['status'],
            'is_featured'    => $request->boolean('is_featured'),
        ]);

        return redirect()->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->authorise($testimonial);
        $testimonial->delete();

        return redirect()->route('dashboard.testimonials.index')
            ->with('success', 'Testimonial deleted.');
    }

    public function approve(Testimonial $testimonial): RedirectResponse
    {
        $this->authorise($testimonial);
        $testimonial->update(['status' => 'approved']);

        return back()->with('success', 'Testimonial approved.');
    }

    public function reject(Testimonial $testimonial): RedirectResponse
    {
        $this->authorise($testimonial);
        $testimonial->update(['status' => 'rejected']);

        return back()->with('success', 'Testimonial rejected.');
    }

    private function authorise(Testimonial $testimonial): void
    {
        abort_unless($testimonial->website->user_id === Auth::id(), 403);
    }
}
