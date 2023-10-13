<?php

namespace D3p0t\Core\Tests\Unit;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PrincipalTest extends TestCase {

    use WithFaker;


    public function testPrincipal() {
        $sut = new Principal();

        $this->assertTrue(true);
    }
}