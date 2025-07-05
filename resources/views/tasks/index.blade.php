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
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الاستحقاق</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التعليقات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

@foreach($tasks as $task)
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

        <!-- الإجراءات -->
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center space-x-4 space-x-reverse">
                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:text-blue-800 text-lg" title="عرض">
                    <i class="fas fa-eye"></i>
                </a>

                @if(auth()->user()->role->name === 'Admin' || $task->user_id === auth()->id())
                    <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:text-yellow-800 text-lg" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-lg" title="حذف"
                                onclick="return confirm('هل أنت متأكد من الحذف؟')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                @endif
            </div>
        </td>

        <!-- عرض التعليقات -->
        <td class="px-6 py-4 whitespace-nowrap text-center">
            <button onclick="toggleComments({{ $task->id }})"
                    class="text-gray-600 hover:text-blue-700 text-lg" title="عرض التعليقات">
                <i class="fas fa-eye"></i>
            </button>
        </td>
    </tr>

    <!-- التعليقات -->
    <tr id="comments-section-{{ $task->id }}" class="hidden">
        <td colspan="6" class="bg-gray-50 px-6 py-4">
            <h4 class="font-semibold mb-2">التعليقات:</h4>
            <ul class="space-y-1 mb-4">
                @foreach($task->comments as $comment)
                    <li class="text-sm text-gray-700 flex justify-between items-center">
                        <div><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</div>
                        @if(auth()->user()->role->name === 'Admin' || auth()->id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">
                                    حذف
                                </button>
                            </form>
                        @endif
                    </li>
                @endforeach

                @if($task->comments->isEmpty())
                    <li class="text-sm text-gray-400">لا توجد تعليقات.</li>
                @endif
            </ul>

            <form action="{{ route('comments.store', $task) }}" method="POST" class="space-y-2">
                @csrf
                <textarea name="content" rows="2" class="w-full border rounded px-3 py-2 text-sm"
                          placeholder="أضف تعليقك..." required></textarea>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                    إرسال التعليق
                </button>
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

<!-- سكربت عرض/إخفاء التعليقات -->
<script>
    function toggleComments(taskId) {
        const section = document.getElementById('comments-section-' + taskId);
        section.classList.toggle('hidden');
    }
</script>
@endsection
