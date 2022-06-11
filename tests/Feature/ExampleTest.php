<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->getJson(route('user.index'));
        $response->assertStatus(200);
    }
}
