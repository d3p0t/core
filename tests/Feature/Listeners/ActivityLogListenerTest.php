<?php

namespace D3p0t\Core\Tests\Feature\Listeners;

use D3p0t\Core\Entities\Model;
use D3p0t\Core\Events\ActivityLog;
use D3p0t\Core\Listeners\ActivityLogListener;
use D3p0t\Core\Tests\TestCase;
use Event;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class ActivityLogListenerTest extends TestCase {


    protected function setUp(): void {
        parent::setUp();

        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Event::listen(
            ActivityLog::class,
            [ActivityLogListener::class, 'handle']
        );
    }

    public function testShouldLogActivityOnCreation() {
        $sut = new class extends Model {
            protected $table = 'test';
        };

        $sut->name = 'TEST NAME';

        $sut->save();

        $this->assertEquals($sut->activities->count(), 1);
        $this->assertEquals($sut->activities[0]->description, 'created');
    }

    public function testShouldLogActivityOnUpdate() {
        $sut = new class extends Model {
            protected $table = 'test';
        };

        $sut->name = 'TEST NAME';

        $sut->save();

        $sut->name = 'UPDATED NAME';

        $sut->save();

        $this->assertEquals($sut->activities->count(), 2);
        $this->assertEquals($sut->activities[0]->description, 'created');
        $this->assertEquals($sut->activities[1]->description, 'updated');
    }

    public function testShouldLogActivityOnDelete() {
        $sut = new class extends Model {
            protected $table = 'test';
        };

        $sut->name = 'TEST NAME';

        $sut->save();

        $sut->delete();

        $this->assertEquals($sut->activities->count(), 2);
        $this->assertEquals($sut->activities[0]->description, 'created');
        $this->assertEquals($sut->activities[1]->description, 'deleted');
    }


    public function testShouldLogActivityDetails() {
        $sut = new class extends Model {
            protected $table = 'test';

            protected $fillable = [
                'name'
            ];
        };

        $sut->name = 'TEST NAME';

        $sut->save();

        $this->assertEquals($sut->activities->count(), 1);
        $this->assertEquals($sut->activities[0]->description, 'created');
        $this->assertEquals($sut->activities[0]->getExtraProperty('attributes.name'), 'TEST NAME');
    }

}