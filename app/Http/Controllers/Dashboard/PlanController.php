<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(): View
    {
        return view('dashboard.plan.index', [
            'user'           => Auth::user(),
            'paymentSettings' => Setting::payment(),
        ]);
    }
}
