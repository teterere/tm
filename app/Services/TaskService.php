<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskStatus;
use DB;
use Illuminate\Support\Collection;

class TaskService
{
    public static function moveTask(Task $task, TaskStatus $newStatus, int $newOrder): void
    {
        DB::transaction(function () use ($task, $newStatus, $newOrder) {
            $originalStatusId = $task->status_id;
            $originalOrder = $task->order;
            $movingToOtherStatus = $originalStatusId !== $newStatus->id;

            self::assignTemporaryOrder($task);
            self::reorderTasksInOldStatus($task, $originalStatusId, $originalOrder, $newOrder, $movingToOtherStatus);
            self::reorderTasksInNewStatus($task, $newStatus->id, $newOrder, $movingToOtherStatus);
            self::finalizeTaskOrder($task, $newStatus->id, $newOrder);
            self::normalizeStatusOrders($newStatus, $task);

            if ($movingToOtherStatus) {
                $oldStatus = TaskStatus::find($originalStatusId);
                if ($oldStatus) {
                    self::normalizeStatusOrders($oldStatus, $task);
                }
            }
        });
    }

    private static function assignTemporaryOrder(Task $task): void
    {
        $temporaryOrder = Task::fromSameCompany($task)->max('order') + 1000;
        $task->order = $temporaryOrder;
        $task->save();
    }

    private static function reorderTasksInOldStatus(Task $task, int $originalStatusId, int $originalOrder, int $newOrder, bool $movingToOtherStatus): void
    {
        if ($movingToOtherStatus) {
            $tasks = Task::fromSameCompany($task)
                ->where('status_id', $originalStatusId)
                ->where('order', '>', $originalOrder)
                ->orderBy('order')
                ->get();

            self::decrementOrderForTasks($tasks);

            return;
        }

        if ($newOrder === $originalOrder) {
            return;
        }

        if ($newOrder > $originalOrder) {
            $tasks = Task::fromSameCompany($task)
                ->where('status_id', $originalStatusId)
                ->where('order', '>', $originalOrder)
                ->where('order', '<=', $newOrder)
                ->orderBy('order', 'asc')
                ->get();

            self::decrementOrderForTasks($tasks);

            return;
        }

        $tasks = Task::fromSameCompany($task)
            ->where('status_id', $originalStatusId)
            ->where('order', '>=', $newOrder)
            ->where('order', '<', $originalOrder)
            ->orderBy('order', 'desc')
            ->get();

        self::incrementOrderForTasks($tasks);
    }

    private static function reorderTasksInNewStatus(Task $task, int $newStatusId, int $newOrder, bool $movingToOtherStatus): void
    {
        if (!$movingToOtherStatus) {
            return;
        }

        $tasks = Task::fromSameCompany($task)
            ->where('status_id', $newStatusId)
            ->where('order', '>=', $newOrder)
            ->orderBy('order', 'desc')
            ->get();

        self::incrementOrderForTasks($tasks);
    }

    private static function finalizeTaskOrder(Task $task, int $newStatusId, int $newOrder): void
    {
        $task->status_id = $newStatusId;
        $task->order = $newOrder;
        $task->save();
    }

    private static function normalizeStatusOrders(TaskStatus $status, Task $task): void
    {
        $tasks = Task::fromSameCompany($task)
            ->where('status_id', $status->id)
            ->orderBy('order')
            ->get();

        $order = 1;
        foreach ($tasks as $reorderedTask) {
            $reorderedTask->order = $order++;
            $reorderedTask->save();
        }
    }

    private static function incrementOrderForTasks(Collection $tasks): void
    {
        foreach ($tasks as $task) {
            $task->order += 1;
            $task->save();
        }
    }

    private static function decrementOrderForTasks(Collection $tasks): void
    {
        foreach ($tasks as $task) {
            $task->order -= 1;
            $task->save();
        }
    }
}
