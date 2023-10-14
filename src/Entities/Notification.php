<?php

namespace D3p0t\Core\Entities;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model {

    protected $table = 'core__notifications';

    protected $fillable = [
        'subject',
        'content',
        'is_read'
    ];

    public function recipient(): MorphTo {
        return $this->morphTo();
    }

    public function read() {
        $this->is_read = true;
        $this->save();
    }
}
