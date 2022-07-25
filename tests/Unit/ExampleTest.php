<?php

namespace Tests\Unit;

use ReflectionClass;
use App\Services\SampleService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ExampleTest extends TestCase
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
     * @group tttt
     * @dataProvider params
     * @param array $params
     * @param string $message
     * @param bool $canEdit
     */
    public function test_getXxx(array $params, string $message, bool $canEdit)
    {
        $result = $this->service->getXxxx($params);

        $this->assertEquals($message, $result['message']);
        $this->assertEquals($canEdit, $result['can_edit']);
    }

    public function params()
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
        $method = $this->reflection->getMethod('firstMethod');
        $method->setAccessible(true);
        $method->invoke($this->service, 5);
    }
}
