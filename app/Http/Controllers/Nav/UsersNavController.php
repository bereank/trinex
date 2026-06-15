<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersNavController extends Controller
{
    public function getUsers()
    {
        return view('pages.users.index', [
            'users' => User::get(),
        ]);
    }

    public function getCreateUsers()
    {
        return view('pages.users.new');
    }

    public function getEditUser($id)
    {
        $user = User::where('id', $id)->first();

        return view('pages.users.edit', [
            'user' => $user,
        ]);
    }
}
