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


    /**
     * [
     *   'isXxxx' => true / false
     *   'canXxx' => true / false
     * ]
     * @param array $params
     * @return array
     */
    public function getXxxx(array $params): array
    {
        if ($params['isXxx']) {

            if ($params['canXxx']) {
                return [
                    'message' => 'どちらもtrueです',
                    'can_edit' => true
                ];
            }

            return [
                'message' => 'isXxxはtrueでcanXxxはfalseです',
                'can_edit' => true
            ];
        }

        if ($params['canXxx']) {
            return [
                'message' => 'isXxxはfalseでCanXxxはtrueです',
                'can_edit' => false
            ];
        }

        return [
            'message' => 'どちらもfalseです',
            'can_edit' => false
        ];
    }

    private function firstMethod(int $typeNumber)
    {
        if (!in_array($typeNumber, array_keys(self::TYPE_NUMBER), true)) {
            throw new BadRequestHttpException('正しい選択を行なってください');
        }

        return self::TYPE_NUMBER[$typeNumber];
    }
}
