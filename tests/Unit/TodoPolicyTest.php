<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Todo;
use App\Policies\TodoPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TodoPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected TodoPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new TodoPolicy();
    }

    #[Test]
    public function any_user_can_view_any_todo_list()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $result = $this->policy->viewAny($user);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function owner_can_view_their_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $result = $this->policy->view($user, $todo);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function non_owner_cannot_view_others_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->for($otherUser)->create();

        // Act
        $result = $this->policy->view($user, $todo);

        // Assert
        $this->assertFalse($result);
    }

    #[Test]
    public function admin_can_view_any_todo()
    {
        // Arrange
        $admin = User::factory()->admin()->create();
        $todo = Todo::factory()->create();

        // Act
        $result = $this->policy->view($admin, $todo);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function any_user_can_create_todo()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $result = $this->policy->create($user);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function owner_can_update_their_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $result = $this->policy->update($user, $todo);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function non_owner_cannot_update_others_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->for($otherUser)->create();

        // Act
        $result = $this->policy->update($user, $todo);

        // Assert
        $this->assertFalse($result);
    }

    #[Test]
    public function owner_can_delete_their_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $result = $this->policy->delete($user, $todo);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function non_owner_cannot_delete_others_todo()
    {
        // Arrange
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $todo = Todo::factory()->for($otherUser)->create();

        // Act
        $result = $this->policy->delete($user, $todo);

        // Assert
        $this->assertFalse($result);
    }

    #[Test]
    public function restore_is_always_denied()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $result = $this->policy->restore($user, $todo);

        // Assert
        $this->assertFalse($result);
    }

    #[Test]
    public function force_delete_is_always_denied()
    {
        // Arrange
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        // Act
        $result = $this->policy->forceDelete($user, $todo);

        // Assert
        $this->assertFalse($result);
    }
}
