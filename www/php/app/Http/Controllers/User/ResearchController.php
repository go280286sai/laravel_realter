<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    public function update(array $data): RedirectResponse
    {
        Research::edit($data);

        return back();
    }

    public function store(Request $request): RedirectResponse
    {
        Research::add($request->all());

        return back();
    }
}
