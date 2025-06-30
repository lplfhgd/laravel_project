<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = Task::with('category')
            ->where('user_id', Auth::id()) // عرض مهام المستخدم فقط
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'long_description' => 'nullable',
            'due_date' => 'required|date|after:now',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'new';
        $validated['due_date'] = Carbon::parse($validated['due_date']);

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'تم إنشاء المهمة بنجاح');
    }

    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه المهمة.');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية لتعديل هذه المهمة.');
        }

        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية لتحديث هذه المهمة.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'long_description' => 'nullable',
            'due_date' => 'required|date',
            'status' => 'required|in:new,in_progress,completed,postponed',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['due_date'] = Carbon::parse($validated['due_date']);

        $task->update($validated);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'تم تحديث المهمة بنجاح');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية لحذف هذه المهمة.');
        }

        $task->comments()->delete();
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'تم حذف المهمة بنجاح');
    }

    public function toggleComplete(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'ليس لديك صلاحية لتعديل حالة هذه المهمة.');
        }

        $task->update([
            'status' => $task->status === 'completed' ? 'in_progress' : 'completed'
        ]);

        return back()->with('success', 'تم تحديث الحالة بنجاح');
    }
}
