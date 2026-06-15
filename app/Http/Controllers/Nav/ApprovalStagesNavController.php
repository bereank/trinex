<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;

class ApprovalStagesNavController extends Controller
{
    public function index()
    {
        return view('pages.approvals.astages.index');
    }

    public function create()
    {
        return view('pages.approvals.astages.create');
    }

    public function edit($id)
    {
        return view('pages.approvals.astages.edit', [
            'id' => $id,
        ]);
    }
}
