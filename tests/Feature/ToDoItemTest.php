<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToDoItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_todo_item()
    {
        $this->actingAs($user = User::factory()->create());

        $this->post("/api/users/{$user->id}/todos", [
            'description' => 'My ToDo',
        ]);

        $this->assertCount(1, $user->fresh()->todos);
        $this->assertEquals('My ToDo', $user->fresh()->todos->first()->description);

        $myTodo = $user->fresh()->todos->first();

        $this->post("/api/todos/{$myTodo->id}/todo-items", [
            'description' => 'My ToDo Item',
        ]);

        $this->assertCount(1, $myTodo->fresh()->todoItems);
        $this->assertEquals('My ToDo Item', $myTodo->fresh()->todoItems->first()->description);
    }

    public function test_user_can_delete_a_todo_item()
    {
        $this->actingAs($user = User::factory()->create());

        $this->post("/api/users/{$user->id}/todos", [
            'description' => 'My ToDo',
        ]);

        $this->assertCount(1, $user->fresh()->todos);
        $this->assertEquals('My ToDo', $user->fresh()->todos->first()->description);

        $myTodo = $user->fresh()->todos->first();

        $this->post("/api/todos/{$myTodo->id}/todo-items", [
            'description' => 'My ToDo Item',
        ]);

        $this->assertCount(1, $myTodo->fresh()->todoItems);
        $this->assertEquals('My ToDo Item', $myTodo->fresh()->todoItems->first()->description);

        $myTodoItem = $myTodo->fresh()->todoItems->first();

        $this->delete("/api/todo-items/{$myTodoItem->id}");

        $this->assertCount(0, $myTodo->fresh()->todoItems);
    }
}
