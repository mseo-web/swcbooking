<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResourceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ResourceRepository $resourceRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resourceRepository = new ResourceRepository(new Resource());
    }

    // Этот тест проверяет:
    // - Создание нового ресурса через репозиторий
    // - Сохранение данных в базе данных
    // - Корректность возвращаемого объекта
    public function test_can_create_resource()
    {
        $data = [
            'name' => 'Test Room',
            'type' => 'room',
            'description' => 'Test Description'
        ];

        $resource = $this->resourceRepository->create($data);

        $this->assertDatabaseHas('resources', $data);
        $this->assertEquals($data['name'], $resource->name);
    }

    // Этот тест проверяет:
    // - Поиск существующего ресурса по ID
    // - Корректность возвращаемых данных
    public function test_can_find_resource()
    {
        $resource = Resource::factory()->create();

        $found = $this->resourceRepository->find($resource->id);

        $this->assertEquals($resource->id, $found->id);
    }
}