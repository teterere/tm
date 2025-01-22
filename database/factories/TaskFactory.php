<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskLabel;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id'  => 1,
            'title'       => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date'    => $this->faker->dateTimeBetween('now', '+1 month'),
            'priority_id' => TaskPriority::inRandomOrder()->first()->id,
            'assignee_id' => User::inRandomOrder()->first()->id,
            'status_id'   => TaskStatus::inRandomOrder()->first()->id,
            'estimate'    => $this->faker->randomFloat(2, 0, 24) + ($this->faker->numberBetween(0, 59) / 60)
        ];
    }
}
