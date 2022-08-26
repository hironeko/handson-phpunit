<?php

namespace Tests\Feature\Http\Controllers\Api\Jokes;

use App\Services\JokeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class JokesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWithoutMocking()
    {
        $response = $this->get('/api/jokes/random');

        $response->assertStatus(200);
        #dd($response->getData());
    }

    public function testWithMocking()
    {
        $test_joke = json_decode(json_encode([
            'type' => 'twopart',
            'setup' => 'What do you call a witch at the beach?',
            'delivery' => 'A Sandwich',
        ]));
        $mock_service = $this->mock(JokeService::class, function($mock) use ($test_joke) {
            $mock->shouldReceive('getJokes')
                 ->andReturn([$test_joke]);
        });

        App::instance(JokeService::class, $mock_service);
        $response = $this->get('/api/jokes/random');

        $response->assertStatus(200);
    }
}
