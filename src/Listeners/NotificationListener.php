<?php

namespace D3p0t\Core\Listeners;

use D3p0t\Core\Entities\Notification;
use D3p0t\Core\Events\Notification as Event;

class NotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Event $event): void
    {
        $notification = new Notification([
            'subject'   => $event->subject(),
            'content'   => $event->content(),
        ]);

        $notification->recipient()->associate($event->recipient());

        $notification->save();
    }

}
