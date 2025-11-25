<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        /** @var User|null $user */
        $user = Auth::user();

        if ($user && $user->two_factor_enabled) {
            // Log out current session and start 2FA flow
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $pending = [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'remember' => (bool) $request->boolean('remember'),
            ];

            $request->session()->put('two_factor_login', $pending);

            // Generate and send 2FA code via email
            $code = $user->generateTwoFactorCode();
            Mail::to($user->email)->send(new TwoFactorCodeMail($code, $user->name ?? $user->email));

            return redirect()->route('two-factor.login')
                ->with('status', 'Chúng tôi đã gửi mã xác thực đến email của bạn. Vui lòng kiểm tra và nhập mã để hoàn tất đăng nhập.');
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}




