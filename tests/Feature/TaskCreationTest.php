<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_task()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/my-tasks/store', [
            'title'       => 'Test Task',
            'description' => 'This is a test description',
            'status'      => 'pending',
            'due_date'    => now()->addDay()->toDateString(),
        ]);
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'user_id' => $user->id
        ]);


        $response->assertStatus(302);
    }
}
