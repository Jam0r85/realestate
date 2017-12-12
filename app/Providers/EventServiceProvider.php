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

        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin'
        ],

        'Illuminate\Mail\Events\MessageSending' => [
            'App\Listeners\Emails\LogSentEmail'
        ],

        'App\Events\StatementCreated' => [
            'App\Listeners\Statements\CreateLettingFeeInvoiceItem',
            'App\Listeners\Statements\CreateReLettingFeeInvoiceItem',
            'App\Listeners\Statements\CreateManagementInvoiceItem',
        ],

        'App\Events\Tenancies\TenancyUpdateStatus' => [
            'App\Listeners\Tenancies\CheckBalances'
        ],

        'App\Events\Invoices\InvoiceUpdateBalances' => [
            'App\Listeners\Invoices\UpdateBalances'
        ],

        'App\Events\Expenses\ExpenseUpdateBalances' => [    
            'App\Listeners\Expenses\UpdateBalances'
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
