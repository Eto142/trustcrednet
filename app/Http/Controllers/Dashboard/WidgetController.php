<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WidgetController extends Controller
{
    public function index(): View
    {
        $websites = Auth::user()->websites()->where('is_active', true)->get();
        return view('dashboard.widget.index', compact('websites'));
    }
}
