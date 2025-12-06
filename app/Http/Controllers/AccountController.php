<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

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
            // Nếu có truyền id trên URL (mở rộng), kiểm tra quyền
            if ($request->has('id') && $request->id != $user->id) {
                // Nếu là admin thì cho phép xem tài khoản bất kỳ
                if (!($user->is_admin ?? false)) {
                    abort(403, 'Bạn không có quyền truy cập tài khoản này.');
                }
            }
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
            // Nếu có truyền id trên URL (mở rộng), kiểm tra quyền
            if ($request->has('id') && $request->id != $user->id) {
                if (!($user->is_admin ?? false)) {
                    abort(403, 'Bạn không có quyền truy cập tài khoản này.');
                }
            }
            $updatedAt = $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '';
            return view('account.edit', compact('user', 'avatarUrl', 'updatedAt'));
    }

    public function editPassword()
    {
        return view('account.password');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

            // Nếu có truyền id trên URL (mở rộng), kiểm tra quyền
            if ($request->has('id') && $request->id != $user->id) {
                if (!($user->is_admin ?? false)) {
                    abort(403, 'Bạn không có quyền cập nhật tài khoản này.');
                }
            }
            $validated = $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:16',
                function($attribute, $value, $fail) {
                    if (trim($value) === '' || preg_match('/^\s+$/u', $value)) {
                        $fail('Họ tên không được chỉ chứa khoảng trắng.');
                    }
                }
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
                function($attribute, $value, $fail) {
                    if (trim($value) === '' || preg_match('/^\s+$/u', $value)) {
                        $fail('Email không được chỉ chứa khoảng trắng.');
                    }
                }
            ],
            'phone' => [
                'required',
                'regex:/^\d{10}$/',
                function($attribute, $value, $fail) {
                    // reject số full-width
                    if (preg_match('/[０-９]/u', $value)) {
                        $fail('Số điện thoại không hợp lệ (không dùng số full-width).');
                    }
                }
            ],
            'address' => [
                'nullable',
                'string',
                'max:100',
                function($attribute, $value, $fail) {
                    if ($value !== null && (trim($value) === '' || preg_match('/^\s+$/u', $value))) {
                        $fail('Địa chỉ không được chỉ chứa khoảng trắng.');
                    }
                }
            ],
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

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'max:255', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'max:255'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác',
            'current_password.max' => 'Mật khẩu hiện tại quá dài',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có tối thiểu 8 ký tự',
            'password.max' => 'Mật khẩu mới quá dài',
            'password.confirmed' => 'Xác nhận mật khẩu chưa khớp',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu mới',
            'password_confirmation.max' => 'Xác nhận mật khẩu mới quá dài',
        ]);

        $user->forceFill([
            'password' => $validated['password']
        ])->save();

        // Refresh the remember token to invalidate other sessions if needed
        $request->session()->regenerateToken();

        return redirect()->route('account.show')->with('success', 'Đổi mật khẩu thành công');
    }

    public function twoFactorForm(Request $request)
    {
        $user = Auth::user();

        if ($user->two_factor_enabled) {
            return redirect()->route('account.show')->with('error', 'Bạn đã bật bảo mật 2FA rồi.');
        }

        $code = $user->generateTwoFactorCode();

        Mail::to($user->email)->send(new TwoFactorCodeMail($code, $user->name ?? $user->email));

        return view('account.two-factor-verify');
    }

    public function twoFactorVerify(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ], [
            'code.required' => 'Vui lòng nhập mã xác thực.',
            'code.digits' => 'Mã xác thực gồm 6 chữ số.',
        ]);

        if (! $user->verifyTwoFactorCode($validated['code'])) {
            return back()->with('error', 'Mã xác thực không chính xác hoặc đã hết hạn.')->withInput();
        }

        $user->forceFill([
            'two_factor_enabled' => true,
        ])->save();

        $user->clearTwoFactorCode();

        return redirect()->route('account.show')->with('success', 'Đã bật bảo mật 2FA cho tài khoản của bạn.');
    }

    public function twoFactorDisable(Request $request)
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_enabled' => false,
        ])->save();

        $user->clearTwoFactorCode();

        return redirect()->route('account.show')->with('success', 'Đã tắt bảo mật 2FA cho tài khoản của bạn.');
    }
}
