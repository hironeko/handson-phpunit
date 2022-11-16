<?php

namespace Tests\Unit\Services;

use App\Services\SampleService;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\TestCase;

class SampleServiceTest extends TestCase
{
    private $service;
    private $reflection;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app()->make(SampleService::class);
        $this->reflection = new ReflectionClass($this->service);
    }

    /**
     * @dataProvider getXxxxParams
     */
    public function test_getXxxx(array $params, string $message, bool $canEdit)
    {
        $result = $this->service->getXxxx($params);

        $this->assertEquals($message, $result['message']);
        $this->assertEquals($canEdit, $result['can_edit']);
    }

    public function getXxxxParams()
    {
        return [
            'どちらもtrue' => [
                [
                    'isXxx' => true,
                    'canXxx' => true
                ],
                'どちらもtrueです',
                true
            ],
            'canXxxはfalse' => [
                [
                    'isXxx' => true,
                    'canXxx' => false
                ],
                'isXxxはtrueでcanXxxはfalseです',
                true
            ],
            'canXxxはtrue' => [
                [
                    'isXxx' => false,
                    'canXxx' => true
                ],
                'isXxxはfalseでCanXxxはtrueです',
                false
            ],
            'どちらもfalse' => [
                [
                    'isXxx' => false,
                    'canXxx' => false
                ],
                'どちらもfalseです',
                false
            ]
        ];
    }

    /**
     * @group tttt
     */
    public function test_first_method_success()
    {
        $method = $this->reflection->getMethod('firstMethod');
        $method->setAccessible(true);
        $result = $method->invoke($this->service, 1);

        $this->assertEquals(
            $this->service::TYPE_NUMBER[1],
            $result
        );
    }

    /**
     * @group tttt
     */
    public function test_first_method_fail()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('正しい選択を行なってください');

        $method = $this->reflection->getMethod('firstMethod');
        $method->setAccessible(true);
        $method->invoke($this->service, 5);
    }
}
