@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-center mb-6">تسجيل الدخول</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
            <input type="email" id="email" name="email"
                   class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">كلمة المرور</label>
            <input type="password" id="password" name="password"
                   class="w-full px-4 py-2 border rounded-lg @error('password') border-red-500 @enderror" required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" id="remember" name="remember" class="mr-2">
            <label for="remember" class="text-gray-700">تذكرني</label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            تسجيل الدخول
        </button>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">إنشاء حساب جديد</a>
        </div>
    </form>
</div>
@endsection
