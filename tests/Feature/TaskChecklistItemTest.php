<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskChecklistItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskChecklistItemTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_can_be_created(): void
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

    public function test_can_be_updated(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->actingAs($user);

        $checklistItem = TaskChecklistItem::create([
            'task_id'     => $task->id,
            'description' => 'Original description',
        ]);

        $data = [
            'description' => 'Updated description'
        ];

        $response = $this->patchJson(route('tasks.checklist-items.update', [
            'task' => $checklistItem->task_id,
            'item' => $checklistItem->id
        ]), $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('task_checklist_items', [
            'id'          => $checklistItem->id,
            'description' => $data['description']
        ]);
    }

    public function test_completed_status_can_be_changed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $checklistItem = TaskChecklistItem::factory()->create();

        $response = $this->patchJson(route('tasks.checklist-items.toggle-complete', [
            'task' => $checklistItem->task_id,
            'item' => $checklistItem->id
        ]));

        $response->assertStatus(200);

        $this->assertDatabaseHas('task_checklist_items', [
            'id'        => $checklistItem->id,
            'completed' => !$checklistItem->completed
        ]);
    }

    public function test_order_can_be_changed(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'company_id' => $user->company_id
        ]);

        $items = TaskChecklistItem::factory(5)->create([
            'task_id' => $task->id
        ]);

        $originalOrder = $items->pluck('order', 'id')->toArray();

        $newOrder = $items->shuffle()->values()->map(function ($item, $index) {
            return [
                'id'    => $item->id,
                'order' => $index,
            ];
        });

        $response = $this->patchJson(route('tasks.checklist-items.update-order', $task->id), [
            'items' => $newOrder
        ]);

        $response->assertStatus(200);

        foreach ($newOrder as $index => $item) {
            $this->assertDatabaseHas('task_checklist_items', [
                'id'    => $item['id'],
                'order' => $index,
            ]);
        }

        $this->assertNotEquals($originalOrder, $newOrder->pluck('order', 'id')->toArray());
    }

    public function test_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::factory()->create();

        $checklistItem = TaskChecklistItem::factory()->create([
            'task_id' => $task->id
        ]);

        $response = $this->deleteJson(route('tasks.checklist-items.delete', [
            'task' => $checklistItem->task_id,
            'item' => $checklistItem->id
        ]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('task_checklist_items', [
            'id' => $checklistItem->id
        ]);
    }

    public function test_all_task_checklist_items_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $task = Task::factory()->create();

        $checklistItems = TaskChecklistItem::factory(5)->create([
            'task_id' => $task->id
        ]);

        $response = $this->deleteJson(route('tasks.checklist-items.delete-all-for-task', [
            'task' => $task->id
        ]));

        $response->assertStatus(200);

        foreach ($checklistItems as $checklistItem) {
            $this->assertDatabaseMissing('task_checklist_items', [
                'id' => $checklistItem->id
            ]);
        }
    }
}
