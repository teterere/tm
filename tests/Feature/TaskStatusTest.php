<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_can_update_task_status_with_valid_status(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);
        $task = Task::factory()->create(['company_id' => $company->id]);
        $status = TaskStatus::inRandomOrder()->first();

        $this->actingAs($user);

        $response = $this->patchJson(route('tasks.update-status', [$task, $status]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id'        => $task->id,
            'status_id' => $status->id,
        ]);
    }

    public function test_cannot_update_task_status_with_nonexistent_status(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();

        $response = $this->patchJson(route('tasks.update-status', [$task, 99999]));

        $response->assertStatus(404);
    }
}
