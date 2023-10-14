<?php

namespace D3p0t\Core\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Orchestra\Testbench\Concerns\WithWorkbench;


abstract class TestCase extends BaseTestCase
{

    use WithWorkbench;

    protected function setUp(): void {
        parent::setUp();

        $this->loadMigrationsFrom(realpath(__DIR__.'/../database/migrations'));
    }

}
