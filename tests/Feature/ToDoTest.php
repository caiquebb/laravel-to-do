<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToDoTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_screen_can_be_rendered()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/todos');

        $response->assertStatus(200);
    }

    public function test_user_can_create_a_todo()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post("/api/users/{$user->id}/todos", [
            'description' => 'My ToDo',
        ]);

        $this->assertCount(1, $user->fresh()->todos);
        $this->assertEquals('My ToDo', $user->fresh()->todos->first()->description);
    }

    public function test_user_can_delete_a_todo()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post("/api/users/{$user->id}/todos", [
            'description' => 'My ToDo',
        ]);

        $this->assertCount(1, $user->fresh()->todos);
        $this->assertEquals('My ToDo', $user->fresh()->todos->first()->description);

        $todo = $user->fresh()->todos->first();

        $response = $this->delete("/api/todos/{$todo->id}");

        $this->assertCount(0, $user->fresh()->todos);
    }

    public function test_user_can_restore_a_deleted_todo()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post("/api/users/{$user->id}/todos", [
            'description' => 'My ToDo',
        ]);

        $this->assertCount(1, $user->fresh()->todos);
        $this->assertEquals('My ToDo', $user->fresh()->todos->first()->description);

        $todo = $user->fresh()->todos->first();

        $response = $this->delete("/api/todos/{$todo->id}");

        $this->assertCount(0, $user->fresh()->todos);
        $this->assertCount(1, $user->fresh()->todos()->onlyTrashed()->get());

        $deletedTodo = $user->fresh()->todos()->onlyTrashed()->first();

        $response = $this->post("/api/todos/{$deletedTodo->id}/restore");

        $this->assertCount(1, $user->fresh()->todos);
        $this->assertEquals('My ToDo', $user->fresh()->todos->first()->description);
    }
}
