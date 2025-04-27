<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskStatus;
use DB;

class TaskService
{
    public static function moveTask(Task $task, TaskStatus $newStatus, int $newOrder): void
    {
        DB::transaction(function () use ($task, $newStatus, $newOrder) {
            $originalStatusId = $task->status_id;
            $originalOrder = $task->order;
            $movingToOtherStatus = $originalStatusId !== $newStatus->id;

            // Assign a temporary order far outside normal range (to avoid conflicts)
            $tempOrder = Task::max('order') + 1000;
            $task->order = $tempOrder;
            $task->status_id = $newStatus->id;
            $task->save();

            // Reorder in old status
            if ($movingToOtherStatus) {
                $tasksToDecrement = Task::where('status_id', $originalStatusId)
                    ->where('order', '>', $originalOrder)
                    ->orderBy('order')
                    ->get();

                foreach ($tasksToDecrement as $task) {
                    $task->order -= 1;
                    $task->save();
                }
            } else {
                // Moving within same status
                if ($newOrder > $originalOrder) {
                    $tasksToDecrement = Task::where('status_id', $originalStatusId)
                        ->where('order', '>', $originalOrder)
                        ->where('order', '<=', $newOrder)
                        ->orderBy('order', 'asc')
                        ->get();

                    foreach ($tasksToDecrement as $task) {
                        $task->order -= 1;
                        $task->save();
                    }
                } else {
                    $tasksToIncrement = Task::where('status_id', $originalStatusId)
                        ->where('order', '>=', $newOrder)
                        ->where('order', '<', $originalOrder)
                        ->orderBy('order', 'desc')
                        ->get();

                    foreach ($tasksToIncrement as $t) {
                        $t->order += 1;
                        $t->save();
                    }
                }
            }

            // In new status, increment all tasks >= newOrder (if moving between statuses)
            if ($movingToOtherStatus) {
                $tasksToIncrement = Task::where('status_id', $newStatus->id)
                    ->where('order', '>=', $newOrder)
                    ->orderBy('order', 'desc')
                    ->get();

                foreach ($tasksToIncrement as $t) {
                    $t->order += 1;
                    $t->save();
                }
            }

            // Put task in the correct place
            $task->order = $newOrder;
            $task->save();

            self::normalizeStatusOrders($newStatus);

            if ($movingToOtherStatus) {
                $oldStatus = TaskStatus::find($originalStatusId);
                if ($oldStatus) {
                    self::normalizeStatusOrders($oldStatus);
                }
            }
        });
    }

    private static function normalizeStatusOrders(TaskStatus $status): void
    {
        $tasks = Task::where('status_id', $status->id)->orderBy('order')->get();
        $i = 1;

        foreach ($tasks as $task) {
            $task->order = $i++;
            $task->save();
        }
    }
}
