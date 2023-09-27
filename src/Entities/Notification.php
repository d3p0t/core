<?php

namespace D3p0t\Core\Entities;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model {

    protected $fillable = [
        'subject',
        'content',
        'recipient',
        'is_read'
    ];

    public function recipient(): MorphTo {
        return $this->morphTo();
    }

}
