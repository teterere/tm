<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskUpdatePriorityRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Requests\Task\TaskUpdateStatusRequest;
use App\Http\Requests\TaskLabels\AddLabelsRequest;
use App\Http\Requests\TaskLabels\RemoveLabelsRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskStatusResource;
use App\Models\Task;
use App\Models\TaskLabel;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use App\TaskEstimateService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(string $taskIdentifier = null): Response
    {
        $statuses = TaskStatus::withTasksForCompany();
        $priorities = TaskPriority::all();
        $employees = User::forAuthorizedCompany()->get();
        $labels = TaskLabel::all();

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
            'employees'  => EmployeeResource::collection($employees)
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(TaskUpdateRequest $request, Task $task): void
    {
        $data = $request->validated();

        if ($request->has('estimate')) {
            $task->update([
                'estimate' => TaskEstimateService::calculateEstimate($request->get('estimate'))
            ]);

            unset($data['estimate']);
        }

        $task->update($data);
    }

    public function updateStatus(TaskUpdateStatusRequest $request, Task $task, TaskStatus $status): void
    {
        $task->update([
            'status_id' => $status->id
        ]);
    }

    public function updatePriority(TaskUpdatePriorityRequest $request, Task $task, TaskPriority $priority): void
    {
        $task->update([
            'priority_id' => $priority->id
        ]);
    }

    public function addLabels(AddLabelsRequest $request, Task $task): void
    {
        [$existingLabelIds, $newLabelsData] = collect($request->get('selectedLabels'))
            ->partition(fn($label) => !is_null($label['id']));

        if ($existingLabelIds->isNotEmpty()) {
            $task->labels()->syncWithoutDetaching($existingLabelIds->pluck('id'));
        }

        $newLabels = auth()->user()->company->labels()->createMany($newLabelsData);

        $task->labels()->syncWithoutDetaching($newLabels->pluck('id'));
    }

    public function removeLabel(RemoveLabelsRequest $request, Task $task, TaskLabel $label): void
    {
        $task->labels()->detach($label->id);
    }

    public function removeAllLabels(RemoveLabelsRequest $request, Task $task): void
    {
        $task->labels()->detach();
    }

    public function destroy(Task $task)
    {
        //
    }
}
