<?php

namespace App\Http\Controllers;

use App\Models\Website;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.homepage');
    }
}
