<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SampleService
{
    const TYPE_NUMBER = [
        1 => 'first',
        2 => 'second',
        3 => 'third',
        4 => 'four'
    ];

    private function firstMethod(int $typeNumber)
    {
        if (!in_array($typeNumber, array_keys(self::TYPE_NUMBER), true)) {
            throw new BadRequestHttpException('正しい選択を行なってください');
        }

        return self::TYPE_NUMBER[$typeNumber];
    }
}
