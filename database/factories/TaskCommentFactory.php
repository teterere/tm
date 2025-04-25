<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TaskComment>
 */
class TaskCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id'   => Task::inRandomOrder()->value('id'),
            'author_id' => rand(1, 10),
            'body'      => fake()->sentence
        ];
    }
}
