<?php

namespace Tests\Feature\Http\Controllers\Api\Jokes;

use App\Services\JokeService;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class JokesControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @group live
     */
    public function testWithoutMocking()
    {
        $this->markTestSkipped('Live API test');
        $response = $this->get('/api/jokes/random');

        $response->assertStatus(200);
        #dd($response->getData());
    }

    /**
     * @group local
     */
    public function testWithMocking()
    {
        $test_joke = json_decode(json_encode([
            'id' => 42,
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
        $response->assertJson([
            'id' => 42,
            'delivery' => 'A Sandwich',
        ]);
    }

    /**
     * @group local
     */
    public function testWithMockingMultipleCalls()
    {
        $test_joke = json_decode(json_encode([
            'id' => 42,
            'type' => 'twopart',
            'setup' => 'What do you call a witch at the beach?',
            'delivery' => 'A Sandwich',
        ]));
        $test_joke2 = json_decode(json_encode([
            'id' => 31415297,
            'type' => 'twopart',
            'setup' => 'Why do programmers prefer using the dark mode?',
            'delivery' => 'Because light attracts bugs.',
        ]));
        $mock_service = $this->mock(JokeService::class, function($mock) use ($test_joke, $test_joke2) {
            $mock->shouldReceive('getJokes')
                 ->andReturns([$test_joke], [$test_joke2]);
        });

        App::instance(JokeService::class, $mock_service);
        # request 1
        $response = $this->get('/api/jokes/random');
        $response->assertStatus(200);
        $response->assertJson([
            'id' => 42,
            'delivery' => 'A Sandwich',
        ]);

        # request 2
        $response = $this->get('/api/jokes/random');
        $response->assertStatus(200);
        $response->assertJson([
            'id' => 31415297,
        ]);
    }

    /**
     * @group local
     */
    public function testWithPartialMockingOfProtectedMethod()
    {
        $test_response = json_decode(json_encode([
            'id' => 42,
            'type' => 'twopart',
            'setup' => 'What do you call a witch at the beach?',
            'delivery' => 'A Sandwich',
        ]));
        $mock_service = $this->mock(JokeService::class, function($mock) use ($test_response) {
            $mock->makePartial();
            $mock->shouldAllowMockingProtectedMethods();
            $mock->shouldReceive('fetchJsonFromUrl')
                 ->andReturn($test_response);
        });

        App::instance(JokeService::class, $mock_service);
        $response = $this->get('/api/jokes/random');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => 42,
            'delivery' => 'A Sandwich',
        ]);
    }
}
