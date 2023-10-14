<?php

namespace D3p0t\Core\Events;

use D3p0t\Core\Auth\Entities\Principal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ActivityLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Model $performedOn;
    private Principal $causedBy;
    private array $properties = [];

    private String $log;

    /**
     * Create a new event instance.
     */
    public function __construct(
        ?String $log = '',
        ?Model $performedOn = null,
        ?Principal $causedBy = null,
        ?array $properties = []
    )
    {
        $this->log = $log;
        $this->properties = $properties;
        $this->performedOn = $performedOn;
        $this->causedBy = $causedBy ?? Auth::user();
    }

    public function log(): String {
        return $this->log;
    }

    public function performedOn(): Model|null {
        return $this->performedOn;
    }

    public function properties(): array {
        return $this->properties;
    }

    public function causedBy(): Principal|null {
        return $this->causedBy;
    }

}
