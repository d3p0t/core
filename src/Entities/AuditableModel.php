<?php

namespace D3p0t\Core\Entities;

use Illuminate\Support\Facades\Auth;

abstract class AuditableModel extends Model {

    protected static function booted(): void
    {
        static::creating(function (AuditableModel $model) {
            $model->created_by = Auth::check() ? strval(Auth::id()) : 'SYSTEM';
        });

        static::updating(function (AuditableModel $model) {
            $model->updated_by = Auth::check() ? strval(Auth::id()) : 'SYSTEM';
        });
    }
    
}
