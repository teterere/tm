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
        'order',
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

    protected static function booted(): void
    {
        static::creating(function (Task $task) {
            // Automatically assign an incremented identifier
            $lastItem = Task::where('company_id', $task->company_id)
                ->orderBy('identifier_number', 'desc')
                ->first();

            $task->identifier_number = $lastItem ? $lastItem->identifier_number + 1 : 1;

            // Assign order
            $lastItem = Task::where('company_id', $task->company_id)
                ->where('status_id', $task->status_id)
                ->orderBy('order', 'desc')
                ->first();

            $task->order = $lastItem ? $lastItem->order + 1 : 1;
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

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->orderBy('created_at', 'desc');
    }

    public function getIdentifierAttribute(): string
    {
        return "{$this->identifier_prefix}-{$this->identifier_number}";
    }

    public function getFormattedEstimateAttribute(): string
    {
        $totalHours = $this->estimate;
        $days = floor($totalHours / 24);
        $remainingHours = floor($totalHours % 24);
        $minutes = round(($totalHours - floor($totalHours)) * 60);

        $parts = [];

        if ($days > 0) {
            $parts[] = "{$days}d";
        }

        if ($remainingHours > 0) {
            $parts[] = "{$remainingHours}h";
        }

        $parts[] = "{$minutes}m";

        return implode(' ', $parts);
    }


    public function getCompletedChecklistItemsCountAttribute(): int
    {
        return $this->checklistItems()->where('completed', true)->count();
    }

    public function belongsToUserCompany(User $user): bool
    {
        return $user->company_id === $this->company_id;
    }

    public static function findByIdentifier(string $identifier) {
        [$prefix, $number] = explode('-', $identifier);

        return self::where('identifier_prefix', $prefix)
            ->where('identifier_number', $number)
            ->where('company_id', auth()->user()?->company_id)
            ->firstOrFail();
    }
}
