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
        // Users
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin'
        ],

        // Emails
        'Illuminate\Mail\Events\MessageSending' => [
            'App\Listeners\Emails\LogSentEmail'
        ],

        // Statements
        'App\Events\StatementWasCreated' => [
            'App\Listeners\TenancyListener@statementCreated'
        ],

        // Statement Payments
        'App\Events\InvoiceStatementPaymentWasSaved' => [
            'App\Listeners\InvoiceListener@statementPaymentSaved',
        ],
        'App\Events\ExpenseStatementPaymentWasSaved' => [
            'App\Listeners\ExpenseListener@statementPaymentSaved',
        ],
        'App\Events\ExpenseStatementPaymentWasSent' => [
            'App\Listeners\ExpenseListener@statementPaymentSent'
        ],

        // Payments
        'App\Events\RentPaymentWasCreated' => [
            'App\Listeners\TenancyListener@rentPaymentCreated'
        ],
        'App\Events\DepositPaymentWasCreated' => [
            'App\Listeners\TenancyListener@depositPaymentCreated'
        ],
        'App\Events\InvoicePaymentWasCreated' => [
            'App\Listeners\InvoiceListener@paymentCreated'
        ],

        // Invoices
        'App\Events\InvoiceItemWasCreated' => [
            'App\Listeners\InvoiceListener@itemCreated'
        ],
        'App\Events\InvoiceItemWasUpdated' => [
            'App\Listeners\InvoiceListener@itemUpdated'
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
