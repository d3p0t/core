<?php

namespace D3p0t\Core\Auth\Entities;

use D3p0t\Core\Traits\Notifiable;
use Enigma\ValidatorTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class Principal extends Authenticatable
{
    use Notifiable, ValidatorTrait;

}
