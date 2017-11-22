<?php

namespace App\Providers;

use App\Agreement;
use App\Deposit;
use App\Document;
use App\Event;
use App\Expense;
use App\Gas;
use App\Invoice;
use App\InvoiceGroup;
use App\Observers\AgreementObserver;
use App\Observers\DocumentObserver;
use App\Observers\ExpenseObserver;
use App\Observers\InvoiceGroupObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use App\Observers\PropertyObserver;
use App\Observers\StatementObserver;
use App\Observers\StatementPaymentObserver;
use App\Observers\TenancyRentObserver;
use App\Observers\UserObserver;
use App\Payment;
use App\Property;
use App\Statement;
use App\StatementPayment;
use App\Tenancy;
use App\TenancyRent;
use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Relation::morphMap([
            Tenancy::class,
            Property::class,
            Invoice::class,
            Expense::class,
            User::class,
            Deposit::class,
            Gas::class
        ]);

        Payment::observe(PaymentObserver::class);
        User::observe(UserObserver::class);
        Document::observe(DocumentObserver::class);
        Expense::observe(ExpenseObserver::class);
        Invoice::observe(InvoiceObserver::class);
        InvoiceGroup::observe(InvoiceGroupObserver::class);
        Statement::observe(StatementObserver::class);
        StatementPayment::observe(StatementPaymentObserver::class);
        Agreement::observe(AgreementObserver::class);
        Property::observe(PropertyObserver::class);
        TenancyRent::observe(TenancyRentObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
