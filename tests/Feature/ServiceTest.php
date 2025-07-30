<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
        $this->serviceData = [
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 99.99,
            'status' => 'active',
        ];
    }

    public function test_admin_can_create_a_service()
    {
        $response = $this->actingAs($this->admin, 'api')
            ->postJson('/api/services', $this->serviceData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'status',
                ],
                'status_code',
            ])
            ->assertJson([
                'status' => true,
                'message' => 'Service created successfully.',
            ]);

        $this->assertDatabaseHas('services', [
            'name' => 'Test Service',
            'price' => 99.99,
        ]);
    }

    public function test_non_admin_cannot_create_a_service()
    {
        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/services', $this->serviceData);

        $response->assertStatus(403);
    }

    public function test_anyone_can_view_services()
    {
        Service::factory()->create($this->serviceData);

        $response = $this->getJson('/api/services');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'status',
                    ],
                ],
                'status_code',
            ]);
    }

    public function test_admin_can_update_a_service()
    {
        $service = Service::factory()->create();
        $updateData = ['name' => 'Updated Service'];

        $response = $this->actingAs($this->admin, 'api')
            ->putJson("/api/services/{$service->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Service updated successfully.',
            ]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Updated Service',
        ]);
    }

    public function test_admin_can_delete_a_service()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin, 'api')
            ->deleteJson("/api/services/{$service->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
