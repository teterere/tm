<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TaskLabel extends Model
{
    protected $fillable = [
        'title',
        'color'
    ];

    protected static function booted(): void
    {
        // Always filter task by authorized user company_id.
        // If filtering is ever not needed, use TaskLabel::withoutGlobalScope()
        static::addGlobalScope('companyScope', function (Builder $query) {
            $companyId = auth()->user()?->company_id;
            $query->whereNull('company_id')
                ->orWhere('company_id', $companyId);
        });
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'label_task', 'label_id', 'task_id');
    }
}
