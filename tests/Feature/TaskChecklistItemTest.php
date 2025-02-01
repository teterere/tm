<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskChecklistItemTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_can_be_created()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->actingAs($user);

        $data = [
            'description' => 'Test checklist item'
        ];

        $response = $this->postJson(route('tasks.checklist-items.store', $task->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('task_checklist_items', [
            'task_id'     => $task->id,
            'description' => $data['description']
        ]);
    }

//    public function test_can_be_updated()
//    {
//
//    }
//
//    public function test_completed_status_can_be_changed()
//    {
//
//    }
//
//    public function test_order_can_be_changed()
//    {
//
//    }
//
//    public function test_can_be_deleted()
//    {
//
//    }
}
