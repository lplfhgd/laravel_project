<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام إدارة المهام')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- شريط التنقل -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('tasks.index') }}" class="text-xl font-bold text-blue-600">
                        <i class="fas fa-tasks mr-2"></i> نظام المهام
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4 space-x-reverse">
                        @auth
                            <a href="{{ route('tasks.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                                <i class="fas fa-home mr-1"></i> الرئيسية
                            </a>
                            <a href="{{ route('tasks.create') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                                <i class="fas fa-plus mr-1"></i> مهمة جديدة
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                                    <i class="fas fa-sign-out-alt mr-1"></i> تسجيل الخروج
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                                <i class="fas fa-sign-in-alt mr-1"></i> تسجيل الدخول
                            </a>
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                                <i class="fas fa-user-plus mr-1"></i> إنشاء حساب
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- رسائل التنبيه -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
                <div class="flex justify-between">
                    <p><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4" role="alert">
                <div class="flex justify-between">
                    <p><i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- المحتوى الرئيسي -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>
