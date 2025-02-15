<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function modify(User $user, Task $task): bool
    {
        return $task->belongsToUserCompany($user);
    }
}
