@extends('layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-center mb-6">إنشاء حساب جديد</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">الاسم الكامل</label>
            <input type="text" id="name" name="name"
                   class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror"
                   value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
            <input type="email" id="email" name="email"
                   class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror"
                   value="{{ old('email') }}" required>
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

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 mb-2">تأكيد كلمة المرور</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            إنشاء حساب
        </button>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">لديك حساب بالفعل؟ سجل الدخول</a>
        </div>
    </form>
</div>
@endsection
