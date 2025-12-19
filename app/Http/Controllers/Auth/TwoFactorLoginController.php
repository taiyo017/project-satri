<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TwoFactorLogin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TwoFactorLoginController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->session()->get('two_factor_user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        return view('auth.two-factor-login', ['email' => $user ? $user->email : '']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = $request->session()->get('two_factor_user_id');

        if (! $userId) {
            return redirect()->route('login')
                ->withErrors(['email' => '2FA session expired. Please login again.']);
        }

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'User not found.']);
        }

        $twoFactor = TwoFactorLogin::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('expires_at', '>=', now())
            ->first();

        if (! $twoFactor) {
            return back()->withErrors(['code' => 'Invalid or expired 2FA code.']);
        }


        $twoFactor->delete();

        Auth::login($user);

        $request->session()->regenerate();

        $request->session()->forget('two_factor_user_id');

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
