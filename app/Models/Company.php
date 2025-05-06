<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_demo'
    ];

    public function tasks(): HasMany
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
