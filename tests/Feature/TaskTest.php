<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Each field is updated separately in the frontend, so we loop to test them individually
     */
    public function test_can_update_each_field_separately(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'title'       => 'Old Title',
            'description' => 'Old Description',
            'due_date'    => '2025-03-08'
        ]);

        $updates = [
            'title'       => 'New Title',
            'description' => 'New Description',
            'due_date'    => '2025-04-22'
        ];

        foreach ($updates as $field => $newValue) {
            $response = $this->patchJson(route('tasks.update', $task), [$field => $newValue]);

            $response->assertStatus(200);
            $this->assertDatabaseHas('tasks', [$field => $newValue]);
        }
    }
}
