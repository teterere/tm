<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskStatus;
use DB;

class TaskService
{
    public static function moveTaskWithinStatus(Task $task, int $newOrder): void
    {
        if ($newOrder === $task->order) {
            return;
        }

        DB::transaction(function () use ($task, $newOrder) {
            if ($newOrder > $task->order) {
                Task::where('status_id', $task->status_id)
                    ->where('order', '>', $task->order)
                    ->where('order', '<=', $newOrder)
                    ->decrement('order');
            } else {
                Task::where('status_id', $task->status_id)
                    ->where('order', '>=', $newOrder)
                    ->where('order', '<', $task->order)
                    ->increment('order');
            }

            $task->update([
                'order' => $newOrder
            ]);
        });
    }

    public static function updateStatus(Task $task, TaskStatus $status, $newOrder): void
    {
        if ($task->status_id === $status->id) {
            self::moveTaskWithinStatus($task, $newOrder);

            return;
        }

        DB::transaction(function () use ($task, $status, $newOrder) {
            Task::where('status_id', $task->status_id)
                ->where('order', '>', $task->order)
                ->decrement('order');

            $task->update([
                'status_id' => $status->id,
                'order'     => $newOrder
            ]);

            Task::where('status_id', $status->id)
                ->where('id', '!=', $task->id)
                ->where('order', '>=', $newOrder)
                ->increment('order');
        });
    }
}
