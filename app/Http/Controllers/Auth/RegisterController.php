<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * عرض نموذج التسجيل
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * معالجة طلب التسجيل
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // دور مستخدم عادي
        ]);

        auth()->login($user);

        return redirect()->route('tasks.index')
            ->with('success', 'تم التسجيل بنجاح!');
    }
}
