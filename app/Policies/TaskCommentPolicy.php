<?php

namespace App\Policies;

use App\Models\TaskComment;
use App\Models\User;

class TaskCommentPolicy
{
    public function modify(User $user, TaskComment $comment): bool
    {
        return $user->id === $comment->author_id;
    }
}
