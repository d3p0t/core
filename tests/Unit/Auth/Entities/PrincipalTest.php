<?php

namespace D3p0t\Core\Tests\Unit\Auth\Entities;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Tests\TestCase;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class PrincipalTest extends TestCase {

    public function testPrincipalShouldHaveNotifiable() {
        $this->assertTrue(in_array(Notifiable::class, class_uses_recursive(Principal::class)));
    }

    public function testPrincipalShouldHaveHasRoles() {
        $this->assertTrue(in_array(HasRoles::class, class_uses_recursive(Principal::class)));
    }
}

