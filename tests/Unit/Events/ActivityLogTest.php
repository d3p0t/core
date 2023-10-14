<?php

namespace D3p0t\Core\Tests\Unit\Events;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Tests\TestCase;
use D3p0t\Core\Events\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogTest extends TestCase {

    public function testShouldMapActivityLog() {
        $log = 'TEST LOG';
        $performedOn = new Class extends Model { };
        $causedBy = new Principal();
        $properties = [
            'foo'   => 'bar'
        ];

        $sut = new ActivityLog(
            log: $log,
            performedOn: $performedOn,
            causedBy: $causedBy,
            properties: $properties
        );

        $this->assertEquals($sut->causedBy(), $causedBy);
        $this->assertEquals($sut->log(), $log);
        $this->assertEquals($sut->properties(), $properties);
        $this->assertEquals($sut->performedOn(), $performedOn);
    }

    public function testShouldMapActivityLogWithCurrentUser() {
        $log = 'TEST LOG';
        $performedOn = new Class extends Model { };
        $causedBy = new Principal();
        $this->actingAs($causedBy);
        $properties = [
            'foo'   => 'bar'
        ];

        $sut = new ActivityLog(
            log: $log,
            performedOn: $performedOn,
            properties: $properties
        );

        $this->assertEquals($sut->causedBy(), $causedBy);
        $this->assertEquals($sut->log(), $log);
        $this->assertEquals($sut->properties(), $properties);
        $this->assertEquals($sut->performedOn(), $performedOn);
    }
}