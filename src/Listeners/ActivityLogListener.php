<?php

namespace D3p0t\Core\Listeners;

use D3p0t\Events\ActivityLog;

class ActivityLogListener
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
    public function handle(ActivityLog $event): void
    {
        $logger = activity();

        if ($event->causedBy()) {
            $logger = $logger->causedBy($event->causedBy());
        }

        if ($event->properties()) {
            $logger = $logger->properties($event->properties());
        }

        if ($event->causedBy()) {
            $logger = $logger->causedBy($event->causedBy());
        }

        $logger->log($event->log());
    }

}
