<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'assignee_id',
        'status_id',
        'priority_id',
        'title',
        'description',
        'due_date',
        'estimate'
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'estimate' => 'float'
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function priority(): HasOne
    {
        return $this->hasOne(TaskPriority::class, 'id', 'priority_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(TaskLabel::class, 'label_task', 'task_id', 'label_id');
    }

    public function checklistItems(): HasMany
    {
        return $this->hasMany(TaskChecklistItem::class)->orderBy('order');
    }

    public function getFormattedEstimateAttribute(): string
    {
        $hours = floor($this->estimate);
        $minutes = round(($this->estimate - $hours) * 60);

        return "{$hours}h {$minutes}min";
    }

    public function getCompletedChecklistItemsCountAttribute(): int
    {
        return $this->checklistItems()->where('completed', true)->count();
    }

    public function belongsToUserCompany(User $user): bool
    {
        return $user->company_id === $this->company_id;
    }
}
