<?php

namespace D3p0t\Events;

use D3p0t\Core\Auth\Entities\Principal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ActivityLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Model $performedOn;
    private Principal $causedBy;
    private Array $properties = [];

    private String $log;

    /**
     * Create a new event instance.
     */
    public function __construct(
        ?String $log = '',
        ?Model $performedOn = null,
        ?Principal $causedBy = null,
        ?Array $properties = []
    )
    {
        $this->log = $log;
        $this->properties = $properties;
        $this->performedOn = $performedOn;
        $this->causedBy = $causedBy || Auth::user();
    }

    public function log(): String {
        return $this->log;
    }

    public function performedOn(): Model|null {
        return $this->performedOn;
    }

    public function properties(): Array {
        return $this->properties;
    }

    public function causedBy(): Principal|null {
        return $this->causedBy;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
