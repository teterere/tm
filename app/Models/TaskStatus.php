<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class TaskStatus extends Model
{
    protected $fillable = [
        'title',
        'key'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }

    public static function withTasksForCompany($companyId = null): Collection
    {
        $companyId = $companyId ?? Auth::user()->company_id;

        return self::with([
            'tasks' => function ($query) use ($companyId) {
                $query->with(['priority', 'assignee', 'status', 'labels', 'checklistItems', 'comments'])
                    ->where('company_id', $companyId)
                    ->orderBy('order');
            }
        ])->get();
    }
}
