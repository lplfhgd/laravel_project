<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * حفظ تعليق جديد
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|min:3',
        ]);

        $task->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'تم إضافة التعليق بنجاح');
    }

    /**
     * تحديث التعليق
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|min:3',
        ]);

        $comment->update($request->only('content'));

        return back()->with('success', 'تم تحديث التعليق بنجاح');
    }

    /**
     * حذف التعليق
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'تم حذف التعليق بنجاح');
    }
}
