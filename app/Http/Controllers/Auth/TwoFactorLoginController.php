<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TwoFactorLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create(Request $request): RedirectResponse|View
    {
        $pending = $request->session()->get('two_factor_login');

        if (! $pending || ! isset($pending['user_id'])) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập hai lớp đã hết hạn. Vui lòng thử lại.');
        }

        return view('auth.two-factor-login', [
            'email' => $pending['email'] ?? null,
            'name' => $pending['name'] ?? null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $pending = $request->session()->get('two_factor_login');

        if (! $pending || ! isset($pending['user_id'])) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập hai lớp đã hết hạn. Vui lòng thử lại.');
        }

        $request->validate([
            'code' => ['required', 'digits:6'],
        ], [
            'code.required' => 'Vui lòng nhập mã xác thực.',
            'code.digits' => 'Mã xác thực gồm 6 chữ số.',
        ]);

        /** @var \App\Models\User|null $user */
        $user = User::find($pending['user_id']);

        if (! $user) {
            $request->session()->forget('two_factor_login');

            return redirect()->route('login')->with('error', 'Không tìm thấy tài khoản để xác thực.');
        }

        if (! $user->verifyTwoFactorCode($request->input('code'))) {
            return back()->withErrors([
                'code' => 'Mã xác thực không chính xác hoặc đã hết hạn.',
            ])->onlyInput('code');
        }

        $user->clearTwoFactorCode();

        $request->session()->forget('two_factor_login');
        $request->session()->regenerate();

        Auth::login($user, $pending['remember'] ?? false);

        return redirect()->intended('/')->with('success', 'Đăng nhập thành công.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $pending = $request->session()->get('two_factor_login');

        if (! $pending || ! isset($pending['user_id'])) {
            return redirect()->route('login')->with('error', 'Phiên đăng nhập hai lớp đã hết hạn. Vui lòng đăng nhập lại.');
        }

        /** @var \App\Models\User|null $user */
        $user = User::find($pending['user_id']);

        if (! $user) {
            $request->session()->forget('two_factor_login');

            return redirect()->route('login')->with('error', 'Không tìm thấy tài khoản để xác thực.');
        }

        $code = $user->generateTwoFactorCode();

        Mail::to($user->email)->send(new TwoFactorCodeMail($code, $user->name ?? $user->email));

        return back()->with('status', 'Đã gửi lại mã xác thực. Vui lòng kiểm tra email của bạn.');
    }
}
