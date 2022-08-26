<?php

namespace App\Http\Controllers\Api\Jokes;

use App\Http\Controllers\Controller;
use App\Services\JokeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class JokesController extends Controller
{
    public function get_one(Request $request)
    {
        /**
         * @var JokeService
         */
        $jokesService = App::make(JokeService::class);

        $jokes = $jokesService->getJokes([JokeService::PARAM_AMOUNT => 1]);
        $joke = $jokes[0] ?? null;

        return response()->json($joke);
    }
}
