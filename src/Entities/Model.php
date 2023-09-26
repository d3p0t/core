<?php

namespace D3p0t\Core\Entities;

use Enigma\ValidatorTrait;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

abstract class Model extends BaseModel {

    use ValidatorTrait, LogsActivity;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }
}
