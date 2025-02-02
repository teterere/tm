<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskChecklistItem\TaskChecklistItemDeleteRequest;
use App\Http\Requests\TaskChecklistItem\TaskChecklistItemStoreRequest;
use App\Http\Requests\TaskChecklistItem\TaskChecklistItemToggleCompleteRequest;
use App\Http\Requests\TaskChecklistItem\TaskChecklistItemUpdateOrderRequest;
use App\Http\Requests\TaskChecklistItem\TaskChecklistItemUpdateRequest;
use App\Models\Task;
use App\Models\TaskChecklistItem;

class TaskChecklistItemController extends Controller
{
    /**
     * @param TaskChecklistItemStoreRequest $request
     * @param Task $task
     * @return void
     */
    public function store(TaskChecklistItemStoreRequest $request, Task $task): void
    {
        TaskChecklistItem::create([
            'task_id'     => $task->id,
            'description' => $request->get('description')
        ]);
    }

    /**
     * @param TaskChecklistItemToggleCompleteRequest $request
     * @param Task $task
     * @param TaskChecklistItem $item
     * @return void
     */
    public function toggleComplete(TaskChecklistItemToggleCompleteRequest $request, Task $task, TaskChecklistItem $item): void
    {
        $item->update([
            'completed' => !$item->completed
        ]);
    }

    /**
     * @param TaskChecklistItemUpdateOrderRequest $request
     * @param Task $task
     * @return void
     */
    public function updateOrder(TaskChecklistItemUpdateOrderRequest $request, Task $task): void
    {
        foreach($request->get('items') as $index => $item) {
            TaskChecklistItem::where('id', $item['id'])->update(['order' => $index]);
        }
    }

    /**
     * @param TaskChecklistItemUpdateRequest $request
     * @param Task $task
     * @param TaskChecklistItem $item
     * @return void
     */
    public function update(TaskChecklistItemUpdateRequest $request, Task $task, TaskChecklistItem $item): void
    {
        $item->update([
            'description' => $request->get('description')
        ]);
    }

    /**
     * @param TaskChecklistItemDeleteRequest $request
     * @param Task $task
     * @param TaskChecklistItem $item
     * @return void
     */
    public function destroy(TaskChecklistItemDeleteRequest $request, Task $task, TaskChecklistItem $item): void
    {
        $item->delete();
    }
}
