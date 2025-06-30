<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

// الصفحة الرئيسية
Route::redirect('/', '/tasks')->name('home');

// مسارات المصادقة
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// مسارات تحتاج مصادقة
Route::middleware('auth')->group(function () {
    // تسجيل الخروج
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // مسارات المهام
    Route::resource('tasks', TaskController::class);

    // تبديل حالة المهمة
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'toggleComplete'])
    ->name('tasks.complete');

    // مسارات التعليقات
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // مسارات التصنيفات
    Route::resource('categories', CategoryController::class);
});
