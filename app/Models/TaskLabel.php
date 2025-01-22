<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaskLabel extends Model
{
    protected $fillable = [
        'title',
        'key',
        'color'
    ];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'label_task', 'label_id', 'task_id');
    }
}
