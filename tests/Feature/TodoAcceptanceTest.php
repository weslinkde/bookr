<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TodoAcceptanceTest extends TestCase
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
        $response = $this->actor->call('GET', 'todos');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('todos');
    }

    public function testCreate()
    {
        $response = $this->actor->call('GET', 'todos/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'todos', $this->Todo->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('todos/'.$this->Todo->id.'/edit');
    }

    public function testEdit()
    {
        $this->actor->call('POST', 'todos', $this->Todo->toArray());

        $response = $this->actor->call('GET', '/todos/'.$this->Todo->id.'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('todo');
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'todos', $this->Todo->toArray());
        $response = $this->actor->call('PATCH', 'todos/1', $this->TodoEdited->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('todos', $this->TodoEdited->toArray());
        $this->assertRedirectedTo('/');
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'todos', $this->Todo->toArray());

        $response = $this->call('DELETE', 'todos/'.$this->Todo->id);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('todos');
    }

}
