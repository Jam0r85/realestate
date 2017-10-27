<?php

namespace App\Providers;

use App\Deposit;
use App\Document;
use App\Event;
use App\Expense;
use App\Gas;
use App\Invoice;
use App\Observers\DocumentObserver;
use App\Observers\PaymentObserver;
use App\Observers\UserObserver;
use App\Payment;
use App\Property;
use App\Tenancy;
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
