<?php

namespace D3p0t\Core\Tests\Feature\Services;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Entities\Notification;
use D3p0t\Core\Tests\TestCase;
use D3p0t\Core\Services\NotificationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Schema;

class NotificationServiceTest extends TestCase {

    private NotificationService $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->sut = new NotificationService();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });

    }

    public function testShouldSendNotification() {
        $recipient = new class extends Principal {
            protected $table = 'users';
        };

        $recipient->name = 'John Doe';

        $recipient->save();

        $message = 'This is a test';

        $notification = new TestNotification($message);

        $this->assertEmpty($recipient->notifications);

        $recipient->notify($notification);

        $recipient = $recipient->fresh();

        $this->assertEquals(1, $recipient->notifications->count());
        $this->assertEquals(1, $recipient->unreadNotifications->count());
        $this->assertEquals($message, $recipient->unreadNotifications[0]->data['message']);
    }

    public function testShouldReadNotification() {
        $recipient = new class extends Principal {
            protected $table = 'users';
        };

        $recipient->name = 'John Doe';

        $recipient->save();

        $notification = new TestNotification('This is a test');

        $this->assertEmpty($recipient->notifications);

        $recipient->notify($notification);

        $recipient = $recipient->fresh();

        $this->assertEquals(1, $recipient->notifications->count());
        $this->assertEquals(1, $recipient->unreadNotifications->count());

        $recipient->notifications[0]->markAsRead();

        $recipient = $recipient->fresh();

        $this->assertEquals(1, $recipient->notifications->count());
        $this->assertEquals(0, $recipient->unreadNotifications->count());
    }

}


class TestNotification extends \Illuminate\Notifications\Notification {

    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toArray($notifiable) {
        return [
            'id'        => $notifiable->id,
            'name'      => $notifiable->name,
            'foo'       => 'bar',
            'message'   => $this->message
        ];
    }

}