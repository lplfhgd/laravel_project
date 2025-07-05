@extends('layouts.app')

@section('title', 'عرض المهمة')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-2">العنوان</h2>
    <h1 class="text-3xl font-bold mb-6">{{ $task->title }}</h1>

    @if($task->description)
        <h2 class="text-xl font-semibold mb-2">الوصف</h2>
        <p class="mb-6 text-gray-700">{{ $task->description }}</p>
    @endif

    @if($task->long_description)
        <h2 class="text-xl font-semibold mb-2">الوصف المفصل</h2>
        <p class="mb-6 text-gray-700 whitespace-pre-line">{{ $task->long_description }}</p>
    @endif

    <div class="mb-6">
        <strong>التصنيف:</strong> {{ $task->category->name }} <br>
        <strong>الحالة:</strong>
        <span class="px-2 py-1 text-xs rounded-full
            @if($task->status == 'completed') bg-green-100 text-green-800
            @elseif($task->status == 'in_progress') bg-yellow-100 text-yellow-800
            @elseif($task->status == 'postponed') bg-red-100 text-red-800
            @else bg-blue-100 text-blue-800 @endif">
            {{ $task->status }}
        </span>
        <br>
        <strong>تاريخ الاستحقاق:</strong> {{ $task->due_date->format('Y-m-d') }}
    </div>

    <a href="{{ route('tasks.index') }}"
       class="inline-block bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition duration-200">
       العودة إلى قائمة المهام
    </a>
</div>
@endsection
