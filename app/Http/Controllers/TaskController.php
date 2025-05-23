<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskDeleteRequest;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdatePriorityRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Requests\Task\TaskUpdateStatusRequest;
use App\Http\Requests\TaskLabels\AddLabelsRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskStatusResource;
use App\Models\Task;
use App\Models\TaskLabel;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use App\Services\TaskEstimateService;
use App\Services\TaskService;
use Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Session;

class TaskController extends Controller
{
    public function index(string $taskIdentifier = null): Response|RedirectResponse
    {
        $statuses = TaskStatus::withTasksForCompany();
        $priorities = TaskPriority::all();
        $employees = User::forAuthorizedCompany()->get();
        $labels = TaskLabel::all();

        $task = null;
        if ($taskIdentifier) {
            $task = Task::findByIdentifier($taskIdentifier);

            if (!$task) {
                return redirect()->route('tasks.index');
            }

            $task->load(['priority', 'assignee', 'status', 'labels', 'checklistItems'])->loadCount('comments');
            $task = new TaskResource($task);
        }

        return Inertia::render('Tasks/Index', [
            'statuses'   => TaskStatusResource::collection($statuses),
            'task'       => $task,
            'priorities' => $priorities,
            'labels'     => $labels,
            'employees'  => EmployeeResource::collection($employees)
        ]);
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $data = $request->all();
        $estimate = TaskEstimateService::calculateEstimate($data['estimate']);
        unset($data['estimate']);

        $task = Task::create(array_merge($request->all(), [
            'company_id' => auth()->user()->company_id,
            'estimate'   => $estimate
        ]));

        $task->refresh();

        return to_route('tasks.show', ['taskIdentifier' => $task->identifier]);
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
        $newOrder = $request->get('order');

        TaskService::moveTask($task, $status, $newOrder);
    }

    public function updatePriority(TaskUpdatePriorityRequest $request, Task $task, TaskPriority $priority): void
    {
        $task->update([
            'priority_id' => $priority->id
        ]);
    }

    public function addLabels(AddLabelsRequest $request, Task $task): void
    {
        [$existingLabelIds, $newLabelsData] = collect($request->get('selectedLabels'))->partition(function ($label) {
            return !is_null($label['id']);
        });

        $newLabels = auth()->user()->company->labels()->createMany($newLabelsData);
        $allLabelIds = $existingLabelIds->pluck('id')->concat($newLabels->pluck('id'));

        $task->labels()->sync($allLabelIds);
    }

    public function destroy(TaskDeleteRequest $request, Task $task): RedirectResponse
    {
        $task->checklistItems()->delete();
        $task->comments()->delete();
        $task->labels()->detach();

        $task->delete();

        return to_route('tasks.index', [], 303);
    }
}
