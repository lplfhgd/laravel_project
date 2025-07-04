@extends('layouts.app')

@section('title', 'قائمة المهام')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">قائمة المهام</h1>
        <a href="{{ route('tasks.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            إنشاء مهمة جديدة
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التصنيف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">حالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الاستحقاق</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
@foreach($tasks as $task)
    <!-- صف المهمة -->
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">
                {{ $task->title }}
            </a>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $task->category->name }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 text-xs rounded-full
                @if($task->status == 'completed') bg-green-100 text-green-800
                @elseif($task->status == 'in_progress') bg-yellow-100 text-yellow-800
                @elseif($task->status == 'postponed') bg-red-100 text-red-800
                @else bg-blue-100 text-blue-800 @endif">
                {{ $task->status }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">{{ $task->due_date->format('Y-m-d') }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex space-x-2">
                @if(auth()->user()->role->name === 'Admin' || $task->user_id === auth()->id())
                    <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:text-yellow-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('هل أنت متأكد؟')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
        </td>
    </tr>

    <!-- صف التعليقات + النموذج -->
    <tr>
        <td colspan="5" class="bg-gray-50 px-6 py-4">
            <!-- عرض التعليقات -->
            <h4 class="font-semibold mb-2">التعليقات:</h4>
            <ul class="space-y-1 mb-4">
                @foreach($task->comments as $comment)
                    <li class="text-sm text-gray-700">
                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                    </li>
                @endforeach
                @if($task->comments->isEmpty())
                    <li class="text-sm text-gray-400">لا توجد تعليقات.</li>
                @endif
            </ul>

            <!-- نموذج إضافة تعليق -->
            <form action="{{ route('comments.store', $task) }}" method="POST" class="space-y-2">
                @csrf
                <textarea name="content" rows="2" class="w-full border rounded px-3 py-2 text-sm" placeholder="أضف تعليقك..." required></textarea>
                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">إرسال التعليق</button>
            </form>
        </td>
    </tr>
@endforeach

                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
@endsection
