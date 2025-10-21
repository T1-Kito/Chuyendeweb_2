<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email này chưa được đăng ký trong hệ thống.',
        ]);

        $email = $request->email;
        
        // Tạo token ngẫu nhiên
        $token = Str::random(64);
        
        // Lưu token vào database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Gửi email thật
        try {
            Mail::to($email)->send(new PasswordResetMail($token, $email));
            
            // Lưu token vào session để kiểm tra
            session(['password_reset_token' => $token, 'password_reset_email' => $email]);

            return redirect()->route('password.verify')->with('status', "Mã xác thực đã được gửi đến email {$email}. Vui lòng kiểm tra email và nhập mã xác thực bên dưới.");
        } catch (\Exception $e) {
            // Nếu gửi email thất bại, vẫn hiển thị mã để test
            session(['password_reset_token' => $token, 'password_reset_email' => $email]);
            
            return redirect()->route('password.verify')->with('status', "Không thể gửi email. 
            <br><strong>Mã xác thực để test:</strong> {$token}
            <br>Vui lòng nhập mã xác thực bên dưới.");
        }
    }

    public function showVerifyForm(): View
    {
        if (!session('password_reset_token')) {
            return redirect()->route('password.request')->with('error', 'Vui lòng yêu cầu mã xác thực trước.');
        }
        
        return view('auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'string', 'size:64'],
        ]);

        $sessionToken = session('password_reset_token');
        $sessionEmail = session('password_reset_email');
        $inputCode = $request->verification_code;

        if (!$sessionToken || !$sessionEmail) {
            return redirect()->route('password.request')->with('error', 'Phiên làm việc đã hết hạn. Vui lòng yêu cầu mã mới.');
        }

        // Kiểm tra mã xác thực
        if ($inputCode === $sessionToken) {
            // Mã đúng, chuyển đến trang đặt lại mật khẩu
            $resetUrl = route('password.reset', ['token' => $sessionToken, 'email' => $sessionEmail]);
            return redirect($resetUrl);
        } else {
            return back()->withErrors([
                'verification_code' => 'Mã xác thực không đúng. Vui lòng kiểm tra lại.',
            ]);
        }
    }
}
