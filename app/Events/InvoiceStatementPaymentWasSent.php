<?php

namespace App\Events;

use App\StatementPayment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceStatementPaymentWasSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The payment we are dealing with.
     * 
     * @var \App\StatementPayment
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @param  \App\StatementPayment  $payment
     * @return void
     */
    public function __construct(StatementPayment $payment)
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
