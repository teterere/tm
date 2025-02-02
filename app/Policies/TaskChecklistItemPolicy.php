<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\TaskChecklistItem;
use App\Models\User;

class TaskChecklistItemPolicy
{
    public function update(User $user, TaskChecklistItem $item, Task $task): bool
    {
        $itemBelongsToTask = $item->task_id === $task->id;

        return $task->belongsToUserCompany($user) && $itemBelongsToTask;
    }

    public function delete(User $user, TaskChecklistItem $item, Task $task): bool
    {
        $itemBelongsToTask = $item->task_id === $task->id;

        return $task->belongsToUserCompany($user) && $itemBelongsToTask;
    }
}
