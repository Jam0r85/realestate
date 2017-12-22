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

        // Deposits
        'App\Events\DepositWasForceDeleted' => [
            'App\Listeners\DepositListener@forceDeleted',
        ],

        // Expenses
        'App\Events\ExpenseWasCreated' => [
            'App\Listeners\ExpenseListener@created'
        ],

        // Notifications
        'Illuminate\Notifications\Events\NotificationSent' => [
            'App\Listeners\LogSmsNotification'
        ],
        
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
            'App\Listeners\TenancyListener@statementCreated',
            'App\Listeners\StatementPaymentListener@statementCreated'
        ],
        'App\Events\StatementWasSent' => [
            'App\Listeners\TenancyListener@statementSent'
        ],

        // Statement Payments
        'App\Events\StatementPaymentWasSent' => [
            'App\Listeners\StatementListener@paymentSent'
        ],
        'App\Events\InvoiceStatementPaymentWasSaved' => [
            'App\Listeners\InvoiceListener@statementPaymentSaved',
        ],
        'App\Events\ExpenseStatementPaymentWasSaved' => [
            'App\Listeners\ExpenseListener@statementPaymentSaved',
        ],
        'App\Events\ExpenseStatementPaymentWasSent' => [
            'App\Listeners\ExpenseListener@statementPaymentSent'
        ],
        'App\Events\InvoiceStatementPaymentWasSent' => [
            'App\Listeners\InvoiceListener@statementPaymentSent',
        ],

        // Rent Payments
        'App\Events\RentPaymentWasCreated' => [
            'App\Listeners\TenancyListener@rentPaymentCreated'
        ],
        'App\Events\RentPaymentWasUpdated' => [
            'App\Listeners\TenancyListener@rentPaymentUpdated'
        ],
        'App\Events\RentPaymentWasDeleted' => [
            'App\Listeners\TenancyListener@rentPaymentDeleted'
        ],

        // Deposit Payments
        'App\Events\DepositPaymentWasCreated' => [
            'App\Listeners\DepositListener@paymentCreated'
        ],
        'App\Events\DepositPaymentWasUpdated' => [
            'App\Listeners\DepositListener@paymentUpdated'
        ],
        'App\Events\DepositPaymentWasDeleted' => [
            'App\Listeners\DepositListener@paymentDeleted'
        ],

        // Invoice Payments
        'App\Events\InvoicePaymentWasCreated' => [
            'App\Listeners\InvoiceListener@paymentCreated'
        ],
        'App\Events\InvoicePaymentWasDeleted' => [
            'App\Listeners\InvoiceListener@paymentDeleted'
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
