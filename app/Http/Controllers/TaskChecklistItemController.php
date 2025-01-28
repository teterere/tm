<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskChecklistItem;
use Illuminate\Http\Request;

class TaskChecklistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Task $task): void
    {
        TaskChecklistItem::create([
            'task_id'     => $task->id,
            'description' => $request->get('description')
        ]);
    }

    public function toggleComplete(Task $task, TaskChecklistItem $item): void
    {
        $item->completed = !$item->completed;
        $item->save();
    }

    public function updateOrder(Request $request, Task $task): void
    {
        foreach($request->get('items') as $index => $item) {
            TaskChecklistItem::where('id', $item['id'])->update(['order' => $index]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskChecklistItem $taskChecklistItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskChecklistItem $taskChecklistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskChecklistItem $taskChecklistItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskChecklistItem $taskChecklistItem)
    {
        //
    }
}
