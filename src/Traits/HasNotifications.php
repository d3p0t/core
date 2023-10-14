<?php

namespace D3p0t\Core\Traits;

use D3p0t\Core\Entities\Notification;
use D3p0t\Core\Events\Notification as Event;

trait HasNotifications
{

    public function notifications() {
        return $this->morphMany(Notification::class, 'recipient');
    }

    public function unreadNotifications() {
        return $this->morphMany(Notification::class, 'recipient')
            ->where('is_read', 0)
            ->get();
    }

    public function readNotifications() {
        return $this->morphMany(Notification::class, 'recipient')
            ->where('is_read', 1)
            ->get();
    }

    public function sendNotification(string $subject, string $content) {
        Event::dispatch($subject, $content, $this);
    }
    
}
