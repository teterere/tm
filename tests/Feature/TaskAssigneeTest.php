<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssigneeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_can_update_assignee_with_valid_user(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);
        $task = Task::factory()->create(['company_id' => $company->id]);

        $this->actingAs($user);

        $response = $this->patchJson(route('tasks.update', $task), ['assignee_id' => $user->id]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'assignee_id' => $user->id,
        ]);
    }

    public function test_cannot_update_assignee_with_nonexistent_user(): void
    {
        $task = Task::factory()->create();

        $response = $this->patchJson(route('tasks.update', $task), ['assignee_id' => 99999]);

        $response->assertStatus(401);
    }

    public function test_cannot_update_assignee_with_user_from_different_company(): void
    {
        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();

        $userFromCompany1 = User::factory()->create(['company_id' => $company1->id]);
        $userFromCompany2 = User::factory()->create(['company_id' => $company2->id]);

        $task = Task::factory()->create(['company_id' => $company1->id]);

        $this->actingAs($userFromCompany1);

        $response = $this->patchJson(route('tasks.update', $task), ['assignee_id' => $userFromCompany2->id]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('assignee_id');
    }

    public function test_can_update_assignee_to_null(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);
        $task = Task::factory()->create(['company_id' => $company->id, 'assignee_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->patchJson(route('tasks.update', $task), ['assignee_id' => null]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'assignee_id' => null
        ]);
    }
}
