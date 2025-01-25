<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskChecklistItem extends Model
{
    use HasFactory;

    protected $table = 'task_checklist_items';

    protected $fillable = [
        'task_id',
        'description',
        'completed'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
