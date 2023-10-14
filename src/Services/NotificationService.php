<?php

namespace D3p0t\Services;

use D3p0t\Core\Entities\Notification;

class NotificationService {

    public function getById(int $id): Notification {
        return Notification::findOrFail($id);
    }

    public function readNotification(int $id): bool {
        $notification = $this->getById($id);
        
        $notification->is_read = true;

        return $notification->save();
    }
    
}
