<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TodoAcceptanceApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->Todo = factory(App\Models\Todo::class)->make([
            // Todo table data
        ]);
        $this->TodoEdited = factory(App\Models\Todo::class)->make([
            // Todo table data
        ]);
        $user = factory(App\Models\User::class)->make();
        $this->actor = $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->actor->call('GET', 'api/v1/todos');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'api/v1/todos', $this->Todo->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['id' => 1]);
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'api/v1/todos', $this->Todo->toArray());
        $response = $this->actor->call('PATCH', 'api/v1/todos/1', $this->TodoEdited->toArray());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseHas('todos', $this->TodoEdited->toArray());
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'api/v1/todos', $this->Todo->toArray());
        $response = $this->call('DELETE', 'api/v1/todos/'.$this->Todo->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJson(['success' => 'todo was deleted']);
    }

}
