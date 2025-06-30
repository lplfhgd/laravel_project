<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // أضف هذا السطر

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // الطريقة الموصى بها
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // أو يمكنك استخدام
        // if (auth()->check() && auth()->user()->role_id == 1)

        return redirect('/')->with('error', 'ليس لديك صلاحية الوصول');
    }
}
