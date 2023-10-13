<?php

namespace D3p0t\Core\Tests\Unit;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class PrincipalTest extends TestCase {

    use WithFaker;


    public function testPrincipalShouldHaveNotifiable() {
        $this->assertTrue(in_array(Notifiable::class, class_uses_recursive(Principal::class)));
    }

    public function testPrincipalShouldHaveHasRoles() {
        $this->assertTrue(in_array(HasRoles::class, class_uses_recursive(Principal::class)));
    }
}

