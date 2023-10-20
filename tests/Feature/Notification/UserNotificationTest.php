<?php

namespace D3p0t\Test\Feature\Notification;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Events\Notification as EventsNotification;
use D3p0t\Core\Listeners\NotificationListener;
use D3p0t\Core\Tests\TestCase;
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
            protected $table = 'users';
            protected $fillable = [
                'name'
            ];
        };

        $sut->name = 'John Doe';

        $sut->save();

        $this->assertEmpty($sut->notifications);

        $notification = new class extends \Illuminate\Notifications\Notification {
            public function via($notifiable) {
                return ['database'];
            }

            public function toArray($notifiable) {
                return [
                    'id'    => $notifiable->id,
                    'name'  => $notifiable->name
                ];
            }
        };

        $sut->notify($notification);

        $sut = $sut->fresh();

        $this->assertEquals($sut->unreadNotifications->count(), 1);
        $this->assertEmpty($sut->readNotifications->count());

        $sut->unreadNotifications[0]->markAsRead();

        $sut = $sut->fresh();
        
        $this->assertEquals(0, $sut->unreadNotifications->count());
        $this->assertEquals(1, $sut->readNotifications->count());
    }
}