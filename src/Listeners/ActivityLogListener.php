<?php

namespace D3p0t\Core\Listeners;

use D3p0t\Core\Events\ActivityLog;

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
            $logger = $logger->withProperties($event->properties());
        }

        if ($event->performedOn()) {
            $logger = $logger->performedOn($event->performedOn());
        }

        $logger->log($event->log());
    }

}
