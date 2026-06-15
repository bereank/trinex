<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function getDashboard()
    {
        return view('auth.login');
    }
}
