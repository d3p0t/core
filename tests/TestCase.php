<?php

namespace D3p0t\Core\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{

    use WithWorkbench;

    protected function setUp(): void {
        parent::setUp();

        $this->loadMigrationsFrom(realpath(__DIR__.'/../database/migrations'));
    }

    protected function invokeMethod(&$object, $methodName, array $parameters = []) {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
