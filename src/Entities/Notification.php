<?php

namespace D3p0t\Core\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model {

    protected $fillable = [
        'subject',
        'content',
        'recipient'
    ];

    public function recipient(): BelongsTo {
        return $this->belongsTo(User::class, 'id', 'recipient_id');
    }

}
