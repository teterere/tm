<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function createChecklistItems(User $user, Task $task): bool
    {
        return $task->belongsToUserCompany($user);
    }

    public function updateChecklistItemOrder(User $user, Task $task): bool
    {
        return $task->belongsToUserCompany($user);
    }

    public function deleteAllChecklistItems(User $user, Task $task): bool
    {
        return $task->belongsToUserCompany($user);
    }
}
