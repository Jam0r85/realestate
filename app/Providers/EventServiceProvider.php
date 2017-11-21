<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Mail\Events\MessageSending' => [
            'App\Listeners\Emails\LogSentEmail'
        ],

        'App\Events\StatementCreated' => [
            'App\Listeners\Statements\CreateLettingFeeInvoiceItem',
            'App\Listeners\Statements\CreateReLettingFeeInvoiceItem',
            'App\Listeners\Statements\CreateManagementInvoiceItem'
        ],

        'Illuminate\Notifications\Events\NotificationSent' => [
            'App\Listeners\LogSmsNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
