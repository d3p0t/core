<?php

namespace D3p0t\Core\Tests\Unit\Auth\Entities;

use Illuminate\Support\Facades\Event;
use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Entities\AuditableModel;
use D3p0t\Core\Entities\Model;
use D3p0t\Core\Tests\TestCase;
class AuditableModelTest extends TestCase {

    public function testCreateAnonymous() {
        Event::fake();
		Model::setEventDispatcher(Event::getFacadeRoot());


        $sut = new class extends AuditableModel { };

        $dispatcher = AuditableModel::getEventDispatcher();

        $dispatcher->dispatch('creating');

        $this->assertEquals($sut->created_by, 'SYSTEM');
    }

    public function testCreateAuth() {
        Event::fake();
		Model::setEventDispatcher(Event::getFacadeRoot());


        $sut = new class extends AuditableModel { };

        $auth = new Principal();
        $auth->id = 1;

        $this->actingAs($auth);

        $dispatcher = AuditableModel::getEventDispatcher();

        $dispatcher->dispatch('creating');

        $this->assertEquals($sut->created_by, '1');
    }
}

