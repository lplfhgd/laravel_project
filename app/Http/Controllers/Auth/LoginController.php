<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * عرض نموذج تسجيل الدخول
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * معالجة طلب تسجيل الدخول
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('tasks.index'))
                ->with('success', 'تم تسجيل الدخول بنجاح!');
        }

        return back()->withErrors([
            'email' => 'بيانات الاعتماد غير صحيحة.',
        ])->onlyInput('email');
    }

    /**
     * تسجيل الخروج
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'تم تسجيل الخروج بنجاح!');
    }
}
