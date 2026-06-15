<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;

class ApprovalTemplatesNavController extends Controller
{
    public function index()
    {
        return view('pages.approvals.atemplates.index');
    }

    public function create()
    {
        return view('pages.approvals.atemplates.create');
    }

    public function edit($id)
    {

        return view('pages.approvals.atemplates.edit', [
            'id' => $id,
        ]);
    }
}
