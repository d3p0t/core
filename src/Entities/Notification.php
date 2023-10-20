<?php

namespace D3p0t\Core\Entities;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification {

    protected $table = 'core__notifications';

}
