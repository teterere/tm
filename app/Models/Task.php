<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'assignee_id',
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

    public function priority(): HasOne
    {
        return $this->hasOne(TaskPriority::class, 'priority_id');
    }
}
