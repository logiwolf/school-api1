<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_student()
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'name' => 'Ali Student',
            'email' => 'ali@example.com',
            'birthdate' => '2015-01-01',
            'grade' => 'Grade 2',
        ];

        $response = $this->actingAs($admin, 'sanctum') // if using Sanctum
            ->postJson('/api/v1/students', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('students', [
            'name' => 'Ali Student',
            'email' => 'ali@example.com',
        ]);
    }
}
