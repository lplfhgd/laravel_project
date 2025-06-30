@extends('layouts.app')

@section('title', 'قائمة المهام')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">قائمة المهام</h1>
        <a href="{{ route('tasks.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-plus mr-1"></i> إنشاء مهمة جديدة
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($tasks->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600">لا توجد مهام متاحة حالياً</p>
            <a href="{{ route('tasks.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                أنشئ مهمتك الأولى
            </a>
        </div>
    @else
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $task->due_date->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
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
                                    <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm px-2 py-1 rounded
                                            {{ $task->status === 'completed' ? 'bg-gray-200 text-gray-800' : 'bg-green-200 text-green-800' }}">
                                            {{ $task->status === 'completed' ? 'إلغاء' : 'إكمال' }}
                                        </button>
                                    </form>
                                </div>
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
    @endif
</div>
@endsection
