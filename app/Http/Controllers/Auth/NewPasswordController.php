<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = $request->email;
        $token = $request->token;

        // Kiểm tra token có hợp lệ không
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return back()->withErrors([
                'email' => 'Token không hợp lệ hoặc đã hết hạn.',
            ]);
        }

        // Kiểm tra token có hết hạn không (24 giờ)
        if (now()->diffInHours($passwordReset->created_at) > 24) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors([
                'email' => 'Token đã hết hạn. Vui lòng yêu cầu mã mới.',
            ]);
        }

        // Cập nhật mật khẩu mới
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            // Xóa token đã sử dụng
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập với mật khẩu mới.');
        }

        return back()->withErrors([
            'email' => 'Không tìm thấy tài khoản.',
        ]);
    }
}
