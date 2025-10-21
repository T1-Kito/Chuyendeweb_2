<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    public function store(Request $request)
    {
        // Simplified implementation
        return redirect()->intended('/');
    }
}
