<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\TaskEstimateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskEstimateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_can_update_estimate_with_valid_formats(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['estimate' => 5]);
        $this->actingAs($user);

        $validEstimates = [
            '2h'    => TaskEstimateService::calculateEstimate('2h'),
            '1d 4h' => TaskEstimateService::calculateEstimate('1d 4h'),
            '30m'   => TaskEstimateService::calculateEstimate('30m'),
        ];

        foreach ($validEstimates as $input => $expected) {
            $response = $this->patchJson(route('tasks.update', $task), ['estimate' => $input]);

            $response->assertStatus(200);
            $this->assertDatabaseHas('tasks', [
                'id'       => $task->id,
                'estimate' => $expected
            ]);
        }
    }

    public function test_cannot_update_estimate_with_invalid_formats(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['estimate' => 5]);
        $this->actingAs($user);

        $invalidEstimates = ['abc', '5x', '1d 11111111111h', '123'];

        foreach ($invalidEstimates as $input) {
            $response = $this->patchJson(route('tasks.update', $task), ['estimate' => $input]);

            $response->assertStatus(422);
            $this->assertDatabaseHas('tasks', [
                'id'       => $task->id,
                'estimate' => 5 // Value should remain unchanged
            ]);
        }
    }
}
