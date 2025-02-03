<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskStatusResource;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(string $taskIdentifier = null): Response
    {
        $statuses = TaskStatus::withTasksForCompany();

        $task = null;
        if ($taskIdentifier) {
            $task = Task::findByIdentifier($taskIdentifier);
            $task?->load(['priority', 'assignee', 'status', 'labels', 'checklistItems']);
            $task = $task ? new TaskResource($task) : null;
        }

        return Inertia::render('Tasks/Index', [
            'statuses' => TaskStatusResource::collection($statuses),
            'task'     => $task
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        //
    }

    public function destroy(Task $task)
    {
        //
    }
}
