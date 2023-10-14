<?php

namespace D3p0t\Events;

use D3p0t\Auth\Entities\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $recipient;
    private String $subject;
    private String $content;


    /**
     * Create a new event instance.
     */
    public function __construct(
        ?String $subject = '',
        ?String $content = '',
        ?User $recipient = null
    )
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->recipient = $recipient;
    }

    public function subject(): String {
        return $this->subject;
    }

    public function content(): String {
        return $this->content;
    }

    public function recipient(): User {
        return $this->recipient;
    }

}
