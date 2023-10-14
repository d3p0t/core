<?php

namespace D3p0t\Core\Events;

use D3p0t\Core\Auth\Entities\Principal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private ?Principal $recipient;
    private String $subject;
    private String $content;


    /**
     * Create a new event instance.
     */
    public function __construct(
        String $subject,
        String $content,
        Principal $recipient
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

    public function recipient(): Principal {
        return $this->recipient;
    }

}
