<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $task->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'تمت إضافة التعليق بنجاح');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        if ($user->id !== $comment->user_id && $user->id !== $comment->task->user_id) {
            abort(403, 'غير مسموح لك حذف هذا التعليق');
        }

        $comment->delete();

        return back()->with('success', 'تم حذف التعليق بنجاح');
    }
}
