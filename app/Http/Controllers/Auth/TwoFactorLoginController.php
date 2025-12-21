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

        // Get all non-expired codes for this user
        $twoFactorCodes = TwoFactorLogin::where('user_id', $user->id)
            ->where('expires_at', '>=', now())
            ->get();

        // Check if any hashed code matches the input
        $validCode = null;
        foreach ($twoFactorCodes as $twoFactor) {
            if (\Hash::check($request->code, $twoFactor->code)) {
                $validCode = $twoFactor;
                break;
            }
        }

        if (! $validCode) {
            return back()->withErrors(['code' => 'Invalid or expired 2FA code.']);
        }

        // Delete the used code
        $validCode->delete();

        Auth::login($user);

        $request->session()->regenerate();

        $request->session()->forget('two_factor_user_id');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Resend the 2FA code
     */
    public function resend(Request $request)
    {
        $userId = $request->session()->get('two_factor_user_id');

        if (! $userId) {
            return response()->json([
                'success' => false,
                'message' => '2FA session expired. Please login again.'
            ], 401);
        }

        $user = User::find($userId);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Delete all previous codes for this user (expire old codes)
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
        \Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code, $user->name));

        return response()->json([
            'success' => true,
            'message' => 'A new verification code has been sent to your email.',
            'expires_at' => now()->addMinutes(10)->toIso8601String()
        ]);
    }
}
