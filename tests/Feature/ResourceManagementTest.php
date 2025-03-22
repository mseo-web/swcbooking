<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Resource;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResourceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Аутентифицируем пользователя для тестов
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    public function test_can_create_resource()
    {
        $resourceData = [
            'name' => 'Конференц-зал А',
            'type' => 'room',
            'description' => 'Большой конференц-зал'
        ];

        $response = $this->postJson('/api/v1/resources', $resourceData);

        $response->assertStatus(201)
                ->assertJson([
                    'name' => $resourceData['name'],
                    'type' => $resourceData['type'],
                    'description' => $resourceData['description']
                ])
                ->assertJsonStructure([
                    'id',
                    'name',
                    'type',
                    'description',
                    'created_at',
                    'updated_at'
                ]);
    }

    public function test_unauthenticated_user_cannot_create_resource()
    {
        // Очищаем текущую аутентификацию
        $this->app->get('auth')->forgetGuards();

        $response = $this->postJson('/api/v1/resources', [
            'name' => 'Test Room',
            'type' => 'room'
        ]);

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function test_can_list_resources()
    {
        // Создаем тестовые данные
        $resource1 = Resource::factory()->create([
            'name' => 'Конференц-зал А',
            'type' => 'room'
        ]);
        
        $resource2 = Resource::factory()->create([
            'name' => 'Конференц-зал Б',
            'type' => 'room'
        ]);

        $response = $this->getJson('/api/v1/resources');

        $response->assertStatus(200)
                ->assertJsonCount(2, 'data')
                ->assertJsonFragment([
                    'name' => 'Конференц-зал А'
                ]);
    }

    public function test_can_show_single_resource()
    {
        $resource = Resource::factory()->create([
            'name' => 'Конференц-зал А',
            'type' => 'room',
            'description' => 'Тестовый зал'
        ]);

        $response = $this->getJson("/api/v1/resources/{$resource->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $resource->id,
                        'name' => $resource->name,
                        'type' => $resource->type,
                        'description' => $resource->description
                    ]
                ]);
    }

    public function test_can_update_resource()
    {
        $resource = Resource::factory()->create();
        $updateData = [
            'name' => 'Обновленный зал',
            'type' => 'room',
            'description' => 'Обновленное описание'
        ];

        $response = $this->putJson("/api/v1/resources/{$resource->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => $updateData
                ]);
    }

    public function test_can_delete_resource()
    {
        $resource = Resource::factory()->create();

        $response = $this->deleteJson("/api/v1/resources/{$resource->id}");

        $response->assertStatus(200)
                ->assertJson(['message' => 'Resource deleted']);
        $this->assertDatabaseMissing('resources', ['id' => $resource->id]);
    }

    public function test_can_view_resource_bookings()
    {
        $resource = Resource::factory()->create();
        
        $response = $this->getJson("/api/v1/resources/{$resource->id}/bookings");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'resource_id',
                            'start_time',
                            'end_time'
                        ]
                    ]
                ]);
    }
}