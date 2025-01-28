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
        'completed',
        'order'
    ];

    protected static function booted(): void
    {
        static::creating(function ($item) {
            // Automatically assign an incremented order index
            $lastItem = TaskChecklistItem::where('task_id', $item->task_id)
                ->orderBy('order', 'desc')
                ->first();

            $item->order = $lastItem ? $lastItem->order + 1 : 1;
        });
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
