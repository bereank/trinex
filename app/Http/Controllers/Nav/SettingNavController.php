<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;

class SettingNavController extends Controller
{
    public function index()
    {
        return view('pages.setting.index');
    }

    public function create()
    {
        return view('pages.setting.create');
    }
}
