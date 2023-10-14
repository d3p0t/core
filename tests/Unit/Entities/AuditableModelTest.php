<?php

namespace D3p0t\Core\Tests\Unit\Auth\Entities;

use Illuminate\Support\Facades\Event;
use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Entities\AuditableModel;
use D3p0t\Core\Entities\Model;
use D3p0t\Core\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class AuditableModelTest extends TestCase {

    protected function setUp(): void {
        parent::setUp();

        Schema::create('audit', function ($table) {
            $table->temporary();
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

    }

    public function testCreateAnonymous() {
        $sut = new class extends AuditableModel {
            protected $table = 'audit';
         };

         $sut->name = 'test';

         $sut->save();

        $this->assertEquals($sut->created_by, 'ANONYMOUS');
        $this->assertNull($sut->updated_by);
    }

    public function testCreateAuth() {
        $sut = new class extends AuditableModel {
            protected $table = 'audit';
         };

        $auth = new Principal();
        $auth->id = 1;

        $this->actingAs($auth);

        $sut->save();

        $this->assertEquals($sut->created_by, '1');
        $this->assertNull($sut->updated_by);
    }

    public function testUpdateAnonymous() {
        $sut = new class extends AuditableModel {
            protected $table = 'audit';
        };

        $sut->name = 'test';

        $sut->save();

        $sut->name = 'update';

        $sut->save();

        $this->assertEquals($sut->created_by, 'ANONYMOUS');
        $this->assertEquals($sut->updated_by, 'ANONYMOUS');
    }

    public function testUpdateAuth() {
        $sut = new class extends AuditableModel {
            protected $table = 'audit';
         };

        $auth = new Principal();
        $auth->id = 1;

        $this->actingAs($auth);

        $sut->name = 'test';
        $sut->save();
        $sut->name = 'update';
        $sut->save();

        $this->assertEquals($sut->created_by, '1');
        $this->assertEquals($sut->updated_by, '1');

    }
}

