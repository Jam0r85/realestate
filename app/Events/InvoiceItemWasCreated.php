<?php

namespace App\Events;

use App\InvoiceItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceItemWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The invoice item we are dealing with.
     * 
     * @var \App\InvoiceItem
     */
    public $item;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(InvoiceItem $item)
    {
        $this->item = $item;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
