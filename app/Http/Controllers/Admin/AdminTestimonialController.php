<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('website')->latest()->paginate(20);
        return view('admin.testimonials', compact('testimonials'));
    }
}
