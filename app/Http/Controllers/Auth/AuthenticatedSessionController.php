<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Mail\TwoFactorCodeMail;
use App\Models\TwoFactorLogin;
use Illuminate\Support\Facades\Mail;


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

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
        }

        $user = Auth::user();

        if ($user->two_factor_enabled) {
            TwoFactorLogin::where('user_id', $user->id)->delete();
            
            // Generate new code
            $code = random_int(100000, 999999);

            // Create new 2FA code with hashed value
            TwoFactorLogin::create([
                'user_id' => $user->id,
                'code' => \Hash::make($code), // Hash the code before storing
                'expires_at' => now()->addMinutes(10),
            ]);

            // Send email with plain code (user needs to see it)
            Mail::to($user->email)->send(new TwoFactorCodeMail($code, $user->name));

            Auth::logout();

            $request->session()->put('two_factor_user_id', $user->id);
            return redirect()->route('two-factor.login')
                ->with('status', 'A 6-digit verification code has been sent to your email.');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
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
