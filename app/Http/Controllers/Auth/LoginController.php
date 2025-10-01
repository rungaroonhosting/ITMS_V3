<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Rate limiting
        $key = Str::transliterate(Str::lower($request->email).'|'.$request->ip());
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        // Check if user exists and is active
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            RateLimiter::hit($key);
            throw ValidationException::withMessages([
                'email' => 'ไม่พบผู้ใช้งานนี้ในระบบ',
            ]);
        }

        if (!$user->is_active) {
            RateLimiter::hit($key);
            throw ValidationException::withMessages([
                'email' => 'บัญชีผู้ใช้นี้ถูกระงับการใช้งาน',
            ]);
        }

        // Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($key);
            
            // Update last login time
            Auth::user()->updateLastLogin();
            
            // Redirect based on role
            return $this->redirectBasedOnRole();
        }

        RateLimiter::hit($key);
        
        throw ValidationException::withMessages([
            'email' => 'ข้อมูลการเข้าสู่ระบบไม่ถูกต้อง',
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('message', 'ออกจากระบบเรียบร้อยแล้ว');
    }

    /**
     * Redirect based on user role
     */
    protected function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin() || $user->isItAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }
        
        return redirect()->intended('/dashboard');
    }
}
