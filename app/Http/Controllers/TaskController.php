<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskStatusResource;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Task $task): RedirectResponse
    {
        $task->load(['priority', 'assignee', 'status', 'labels', 'checklistItems']);

        return response()->json([
            'task' => new TaskResource($task)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
