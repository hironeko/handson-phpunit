<?php

namespace Tests\Unit\Services;

use App\Services\SampleService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
    public function test_first_method_fail2()
    {
        $this->expectException(BadRequestHttpException::class);
        $method = $this->reflection->getMethod('firstMethod');
        $method->setAccessible(true);
        $method->invokeArgs($this->service, [5]);
    }
}
