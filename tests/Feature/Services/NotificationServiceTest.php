<?php

namespace D3p0t\Core\Tests\Feature\Services;

use D3p0t\Core\Auth\Entities\Principal;
use D3p0t\Core\Entities\Notification;
use D3p0t\Core\Tests\TestCase;
use D3p0t\Core\Services\NotificationService;
use Illuminate\Database\Schema\Blueprint;
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

        $notification = new Notification([
            'subject'   => 'Test notification',
            'content'   => 'This is a test notification',
            'is_read'   => false
        ]);

        $notification->recipient()->associate($recipient);

        $notification->save();

        $res = $this->sut->getById($notification->id);

        $this->assertEquals($res->recipient->id, $recipient->id);
        $this->assertEquals($res->is_read, 0);
        $this->assertEquals($res->subject, 'Test notification');
        $this->assertEquals($res->content, 'This is a test notification');
    }

}
