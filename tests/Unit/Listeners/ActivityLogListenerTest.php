<?php

namespace D3p0t\Core\Tests\Unit\Listeners;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Entities\Model;
use D3p0t\Core\Events\ActivityLog;
use D3p0t\Core\Listeners\ActivityLogListener;
use D3p0t\Core\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use Spatie\Activitylog\ActivityLogger;

class ActivityLogListenerTest extends TestCase {

    protected function tearDown(): void {
        Mockery::close();
    }

    public function testShouldMapBasicActivityLog() {
        $sut = new ActivityLogListener();

        $model = new class extends Model { };

        $causedBy = new class extends Principal { };

        $event = new ActivityLog(
            log: 'Log',
            performedOn: $model,
            causedBy: $causedBy
        );

        $mock = $this->mock(ActivityLogger::class, function(MockInterface $mockInterface) {
            $mockInterface->shouldReceive('useLog')
                ->andReturn($mockInterface);

            $mockInterface->shouldReceive('setLogStatus')
                ->andReturn($mockInterface);
        });
        
        $mock->shouldReceive('performedOn')
            ->once()
            ->withArgs([$model]);
        $mock->shouldReceive('log')
            ->once()
            ->withArgs(['Log']);
        $mock->shouldReceive('causedBy')
            ->once()
            ->withArgs([$causedBy]);

        $sut->handle($event);

        $this->assertTrue(true);
    }

    public function testShouldMapActivityLogWithFillable() {
        $sut = new ActivityLogListener();

        $model = new class extends Model {
        };

        $event = new ActivityLog(
            log: 'Log',
            performedOn: $model,
            properties: [
                'name'  => 'Name'
            ]
        );

        $mock = $this->mock(ActivityLogger::class, function(MockInterface $mockInterface) {
            $mockInterface->shouldReceive('useLog')
                ->andReturn($mockInterface);

            $mockInterface->shouldReceive('setLogStatus')
                ->andReturn($mockInterface);
        });
        
        $mock->shouldReceive('performedOn')
            ->once()
            ->withArgs([$model]);
        $mock->shouldReceive('log')
            ->once()
            ->withArgs(['Log']);
        $mock->shouldReceive('withProperties')
            ->once()
            ->withArgs([['name' => 'Name']]);

        $sut->handle($event);

        $this->assertTrue(true);
    }
}

