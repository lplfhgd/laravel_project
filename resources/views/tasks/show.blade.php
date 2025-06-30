@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $task->title }}</h1>
            <p class="text-gray-500">{{ $task->category->name }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm
              @if($task->status == 'completed') bg-green-100 text-green-800
              @elseif($task->status == 'in_progress') bg-yellow-100 text-yellow-800
              @elseif($task->status == 'postponed') bg-red-100 text-red-800
              @else bg-blue-100 text-blue-800 @endif">
            {{ $task->status }}
        </span>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">الوصف</h2>
        <p class="text-gray-700">{{ $task->description }}</p>
    </div>

    @if($task->long_description)
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">وصف مفصل</h2>
        <p class="text-gray-700 whitespace-pre-line">{{ $task->long_description }}</p>
    </div>
    @endif

    <div class="mb-6 grid grid-cols-2 gap-4">
        <div>
            <h3 class="text-sm font-medium text-gray-500">تاريخ الإنشاء</h3>
            <p>{{ $task->created_at->format('Y-m-d H:i') }}</p>
        </div>
        <div>
            <h3 class="text-sm font-medium text-gray-500">تاريخ الاستحقاق</h3>
            <p>{{ $task->due_date->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <div class="flex justify-between items-center border-t pt-4">
        <div class="flex space-x-2">
            <a href="{{ route('tasks.edit', $task) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                تعديل
            </a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
                        onclick="return confirm('هل أنت متأكد من حذف هذه المهمة؟')">
                    حذف
                </button>
            </form>
        </div>

        <form action="{{ route('tasks.complete', $task) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                {{ $task->status == 'completed' ? 'إلغاء الإكمال' : 'تمييز كمكتمل' }}
            </button>
        </form>
    </div>

    <!-- قسم التعليقات -->
    <div class="mt-8 border-t pt-6">
        <h3 class="text-lg font-semibold mb-4">التعليقات</h3>

        @foreach($task->comments as $comment)
        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-medium">{{ $comment->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                @if($comment->user_id == auth()->id())
                <div class="flex space-x-2">
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>
            <p class="mt-2">{{ $comment->content }}</p>
        </div>
        @endforeach

        <form method="POST" action="{{ route('comments.store', $task) }}" class="mt-4">
            @csrf
            <textarea name="content" rows="3"
                      class="w-full px-4 py-2 border rounded-lg"
                      placeholder="أضف تعليقًا..."></textarea>
            <button type="submit"
                    class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                إرسال
            </button>
        </form>
    </div>
</div>
@endsection
