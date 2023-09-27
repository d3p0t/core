<?php

namespace D3p0t\Listeners;

use D3p0t\Core\Entities\Notification;
use D3p0t\Events\Notification as Event;

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
            'recipient' => $event->recipient()
        ]);

        $notification->save();
    }

}
