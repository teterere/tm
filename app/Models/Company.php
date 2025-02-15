<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'title'
    ];

    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function labels(): HasMany
    {
        return $this->hasMany(TaskLabel::class);
    }
}
