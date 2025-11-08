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
        $avatarUrl = $user->avatar
            ? (str_starts_with($user->avatar, 'http') ? $user->avatar : (\Illuminate\Support\Str::startsWith($user->avatar, 'storage/') ? ('/' . ltrim($user->avatar, '/')) : asset('storage/' . ltrim($user->avatar, '/'))))
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'U') . '&background=0D6EFD&color=fff&size=256';

        return view('account.show', compact('user', 'avatarUrl'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $avatarUrl = $user->avatar
            ? (str_starts_with($user->avatar, 'http') ? $user->avatar : (\Illuminate\Support\Str::startsWith($user->avatar, 'storage/') ? ('/' . ltrim($user->avatar, '/')) : asset('storage/' . ltrim($user->avatar, '/'))))
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'U') . '&background=0D6EFD&color=fff&size=256';
        return view('account.edit', compact('user', 'avatarUrl'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'regex:/^\d{1,11}$/'],
            'address' => ['nullable', 'string', 'max:255'],
        ], [
            'avatar.image' => 'Ảnh không hợp lệ',
            'avatar.mimes' => 'Ảnh không hợp lệ',
            'avatar.max' => 'File quá lớn',
            'name.required' => 'Vui lòng nhập họ tên',
            'name.min' => 'Họ tên không hợp lệ',
            'name.max' => 'Họ tên không hợp lệ',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'address.max' => 'Địa chỉ quá dài',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $validated['avatar'] = $path; // store as relative path under storage/app/public
        }

        $user->update($validated);

        return redirect()->route('account.show')->with('success', 'Cập nhật thành công');
    }
}
