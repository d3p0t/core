<?php

namespace D3p0t\Core\Auth\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Principal extends Authenticatable
{
    use Notifiable, HasRoles;

}
