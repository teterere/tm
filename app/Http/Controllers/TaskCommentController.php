<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskCommentRequest;
use App\Models\Task;
use App\Models\TaskComment;

class TaskCommentController extends Controller
{
    public function store(TaskCommentRequest $request, Task $task): void
    {
        TaskComment::create(array_merge($request->all(), [
            'task_id'   => $task->id,
            'author_id' => auth()->id()
        ]));
    }
}
