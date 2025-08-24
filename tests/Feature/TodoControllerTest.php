<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function user_can_create_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $payload = [
            'title' => 'Teszt feladat',
            'description' => 'Ez egy teszt leírás',
        ];

        // Act
        $response = $this->actingAs($user)->postJson('/api/todos', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Teszt feladat']);
        $this->assertDatabaseHas('todos', ['title' => 'Teszt feladat']);
    }

    #[Test]
    public function user_can_view_own_todos()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $response = $this->actingAs($user)->getJson('/api/todos');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $todo->id]);
    }

    #[Test]
    public function user_cannot_view_others_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->for($otherUser)->create();

        // Act
        $response = $this->actingAs($user)->getJson("/api/todos/{$todo->id}");

        // Assert
        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_view_all_todos()
    {
        // Arrange
        $admin = User::factory()->create(['is_admin' => true]);
        $todo = Todo::factory()->create();

        // Act
        $response = $this->actingAs($admin)->getJson('/api/todos');

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $todo->id]);
    }

    #[Test]
    public function user_can_update_own_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        $updateData = ['title' => 'Frissített cím'];

        // Act
        $response = $this->actingAs($user)->putJson("/api/todos/{$todo->id}", $updateData);

        // Assert
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Frissített cím']);
        $this->assertDatabaseHas('todos', ['title' => 'Frissített cím']);
    }

    #[Test]
    public function user_cannot_update_others_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->for($otherUser)->create();

        $updateData = ['title' => 'Tiltott frissítés'];

        // Act
        $response = $this->actingAs($user)->putJson("/api/todos/{$todo->id}", $updateData);

        // Assert
        $response->assertStatus(403);
    }

    #[Test]
    public function user_can_delete_own_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $response = $this->actingAs($user)->deleteJson("/api/todos/{$todo->id}");

        // Assert
        $response->assertStatus(202)
                 ->assertJson(['message' => "A(z) {$todo->id} azonosítójú rekord törölve."]);
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    #[Test]
    public function user_cannot_delete_others_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->for($otherUser)->create();

        // Act
        $response = $this->actingAs($user)->deleteJson("/api/todos/{$todo->id}");

        // Assert
        $response->assertStatus(403);
    }
}

