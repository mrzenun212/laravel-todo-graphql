<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/graphql', [
            'query' => 'mutation {
                createTask(name: "New Task") {
                    id
                    name
                    state
                }
            }',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['data' => ['createTask' => ['name' => 'New Task', 'state' => false]]]);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/graphql', [
            'query' => 'mutation {
                updateTask(id: ' . $task->id . ', name: "Updated Task", state: true) {
                    id
                    name
                    state
                }
            }',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['data' => ['updateTask' => ['name' => 'Updated Task', 'state' => true]]]);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/graphql', [
            'query' => 'mutation {
                deleteTask(id: ' . $task->id . ') {
                    id
                }
            }',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_can_view_own_tasks()
    {
        $user = User::factory()->create();
        $task1 = Task::factory()->create(['user_id' => $user->id]);
        $task2 = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/graphql', [
            'query' => '{
                tasks {
                    id
                    name
                    state
                }
            }',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data.tasks');
    }
}
