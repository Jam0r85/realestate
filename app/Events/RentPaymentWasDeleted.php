<?php

namespace App\Events;

use App\Payment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RentPaymentWasDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * THe payment we are dealing with.
     * 
     * @var  \App\Payment
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @param  \App\Payment  $payment
     * @return  void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
