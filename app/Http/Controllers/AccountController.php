<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $user = Auth::user();

        // Derive avatar URL: use user->avatar if present, else a default placeholder
        $avatarUrl = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'U') . '&background=0D6EFD&color=fff&size=256';

        return view('account.show', compact('user', 'avatarUrl'));
    }
}
