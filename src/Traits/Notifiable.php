<?php

namespace D3p0t\Core\Traits;

use D3p0t\Core\Entities\Notification;
use Illuminate\Notifications\Notifiable as BaseNotifiable;

trait Notifiable
{
    use BaseNotifiable;

    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this
            ->morphMany(Notification::class, 'notifiable')
            ->latest();
    }
}
