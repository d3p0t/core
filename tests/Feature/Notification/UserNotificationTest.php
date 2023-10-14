<?php

namespace D3p0t\Test\Feature\Notification;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Entities\Notification;
use D3p0t\Core\Events\Notification as EventsNotification;
use D3p0t\Core\Listeners\NotificationListener;
use D3p0t\Core\Tests\TestCase;
use D3p0t\Core\Traits\HasNotifications;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Event;
use Schema;

class UserNotificationTest extends TestCase {

    protected function setUp(): void {
        parent::setUp();
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Event::listen(
            EventsNotification::class,
            [NotificationListener::class, 'handle']
        );
    }

    public function testSendNotificationToUser() {
        $sut = new class extends Principal {
            use HasNotifications;
            protected $table = 'users';
            protected $fillable = [
                'name'
            ];
        };

        $sut->name = 'John Doe';

        $sut->save();

        $this->assertEmpty($sut->notifications);

        $sut->sendNotification('Subject', 'Content');

        $this->assertEquals($sut->unreadNotifications()->count(), 1);
        $this->assertEmpty($sut->readNotifications()->count());

        $sut->unreadNotifications()[0]->read();

        $this->assertEmpty($sut->unreadNotifications()->count());
        $this->assertEquals($sut->readNotifications()->count(), 1);
    }
}