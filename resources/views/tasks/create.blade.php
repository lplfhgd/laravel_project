@extends('layouts.app')

@section('title', 'إنشاء مهمة جديدة')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">إنشاء مهمة جديدة</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 mb-2">عنوان المهمة</label>
            <input type="text" id="title" name="title"
                   class="w-full px-4 py-2 border rounded-lg @error('title') border-red-500 @enderror"
                   value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 mb-2">الوصف</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full px-4 py-2 border rounded-lg @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="long_description" class="block text-gray-700 mb-2">وصف مفصل (اختياري)</label>
            <textarea id="long_description" name="long_description" rows="5"
                      class="w-full px-4 py-2 border rounded-lg">{{ old('long_description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="due_date" class="block text-gray-700 mb-2">تاريخ الاستحقاق</label>
            <input type="datetime-local" id="due_date" name="due_date"
                   class="w-full px-4 py-2 border rounded-lg @error('due_date') border-red-500 @enderror"
                   value="{{ old('due_date') }}" required>
            @error('due_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 mb-2">التصنيف</label>
            <select id="category_id" name="category_id"
                    class="w-full px-4 py-2 border rounded-lg @error('category_id') border-red-500 @enderror" required>
                <option value="">اختر تصنيفًا</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

