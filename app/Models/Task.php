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
        'identifier_prefix',
        'identifier_number',
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

    protected $appends = ['identifier'];

    protected static function booted(): void
    {
        static::creating(function (Task $task) {
            // Automatically assign an incremented identifier
            $lastItem = Task::where('company_id', $task->company_id)
                ->orderBy('identifier_number', 'desc')
                ->first();

            $task->identifier_number = $lastItem ? $lastItem->identifier_number + 1 : 1;
        });
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

    public function getIdentifierAttribute(): string
    {
        return "{$this->identifier_prefix}-{$this->identifier_number}";
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
