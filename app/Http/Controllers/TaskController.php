<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskStatusResource;
use App\Models\Task;
use App\Models\TaskLabel;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(string $taskIdentifier = null): Response
    {
        $statuses = TaskStatus::withTasksForCompany();
        $priorities = TaskPriority::all();
        $employees = auth()->user()->company->employees;
        $labels = TaskLabel::all(); // todo: for company of where company id null

        $task = null;
        if ($taskIdentifier) {
            $task = Task::findByIdentifier($taskIdentifier);
            $task?->load(['priority', 'assignee', 'status', 'labels', 'checklistItems']);
            $task = $task ? new TaskResource($task) : null;
        }

        return Inertia::render('Tasks/Index', [
            'statuses'   => TaskStatusResource::collection($statuses),
            'task'       => $task,
            'priorities' => $priorities,
            'labels'     => $labels,
            'employees'  => $employees
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Task $task): void
    {
        $task->update($request->all());
    }

    public function updateStatus(Task $task, TaskStatus $status): void
    {
        $task->update([
            'status_id' => $status->id
        ]);
    }

    public function updatePriority(Task $task, TaskStatus $priority): void
    {
        $task->update([
            'priority_id' => $priority->id
        ]);
    }

    public function addLabels(Request $request, Task $task): void
    {
        [$existingLabelIds, $newLabelsData] = collect($request->get('selectedLabels'))
            ->partition(fn ($label) => !is_null($label['id']));

        if ($existingLabelIds->isNotEmpty()) {
            $task->labels()->syncWithoutDetaching($existingLabelIds->pluck('id'));
        }

        $newLabels = auth()->user()->company->labels()->createMany($newLabelsData);

        $task->labels()->syncWithoutDetaching($newLabels->pluck('id'));
    }

    public function removeLabel(Task $task, TaskLabel $label): void
    {
        $task->labels()->detach($label->id);
    }

    public function destroy(Task $task)
    {
        //
    }
}
