<?php

namespace App\Services;

use App\Exceptions\JokeException;

class JokeService
{
    const API_ENDPOINT = 'https://v2.jokeapi.dev/joke/Any';

    const PARAM_LANGUAGE = 'lang';
    const PARAM_AMOUNT = 'amount';

    const LANG_ENGLISH = 'en';
    const LANG_FRENCH = 'fr';
    const LANG_SPANISH = 'es';

    const DEFAULT_AMOUNT = 1;
    const DEFAULT_LANGUAGE = self::LANG_ENGLISH;

    /**
     * @param array $params
     * @return array array of JSON objects
     * @throws JokeException
     */
    public function getJokes(array $params = []): array
    {
        $defaults = [
            self::PARAM_LANGUAGE => self::DEFAULT_LANGUAGE,
            self::PARAM_AMOUNT   => self::DEFAULT_AMOUNT,
        ];
        $params = array_merge($defaults, $params);

        $amount = $params[self::PARAM_AMOUNT];

        $json = $this->fetchJsonFromUrl(self::API_ENDPOINT, $params);

        # when only one joke asked, the API doesn't return a `jokes` array,but a single document
        if ($amount === 1) {
            return [$json];
        }

        return $json->jokes;
    }

    /**
     * @param string $url
     * @return object JSON object
     * @throws JokeException
     */
    protected function fetchJsonFromUrl(string $url, array $params = []): object
    {
        if($json = json_decode(file_get_contents($url . '?' . http_build_query($params)))) {
            if ($json->error != false) {
                throw new JokeException('API Error');
            }

            return $json;
        }
        throw new JokeException('Invalid JSON from API');
    }
}
