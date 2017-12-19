<?php

namespace App\Events;

use App\Deposit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositWasForceDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The deposit we are dealing with.
     * 
     * @var  \App\Deposit
     */
    public $deposit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
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
