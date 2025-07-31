<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'user']);
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->service = Service::factory()->create(['status' => 'active']);
        $this->bookingData = [
            'service_id' => $this->service->id,
            'booking_date' => now()->addDays(7)->format('Y-m-d'),
        ];
    }

    public function test_user_can_create_a_booking()
    {
        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/bookings', $this->bookingData);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'Booking created successfully.',
                'status_code' => 201,
            ])->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'service_id',
                    'booking_date',
                ],
            ])
            ->assertJson([
                'status' => true,
                'message' => 'Booking created successfully.',
            ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->user->id,
            'service_id' => $this->service->id,
        ]);
    }

    public function test_user_cannot_book_on_past_date()
    {
        $pastBookingData = [
            'service_id' => $this->service->id,
            'booking_date' => now()->subDays(1)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user, 'api')
            ->postJson('/api/bookings', $pastBookingData);

        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
            ]);
    }

    public function test_user_can_view_their_own_bookings()
    {
        Booking::factory()->create([
            'user_id' => $this->user->id,
            'service_id' => $this->service->id,
        ]);

        $response = $this->actingAs($this->user, 'api')
            ->getJson('/api/bookings');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'service_id',
                        'booking_date',
                        'status',
                    ],
                ],
                'status_code',
            ]);
    }

    public function test_admin_can_view_all_bookings()
    {
        Booking::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'api')
            ->getJson('/api/admin/bookings');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'service_id',
                        'booking_date',
                        'status',
                    ],
                ],
                'status_code',
            ]);
    }

    public function test_non_admin_cannot_view_all_bookings()
    {
        $response = $this->actingAs($this->user, 'api')
            ->getJson('/api/admin/bookings');

        $response->assertStatus(403);
    }
}
