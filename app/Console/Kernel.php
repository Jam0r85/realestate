<?php

namespace App\Console;

use App\Jobs\GenerateRecurringInvoices;
use App\Jobs\SendUnsentStatements;
use App\Jobs\UpdateTenancyDepositBalances;
use App\Jobs\UpdateTenancyRentBalances;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tenancy:check-overdue')->dailyAt('09:00');
        $schedule->command('statement:check-paid')->everyThirtyMinutes();
        $schedule->command('invoice:check-paid')->everyThirtyMinutes();
        $schedule->command('expense:check-paid')->everyThirtyMinutes();
        $schedule->command('deposit:archive')->daily();

        $schedule->job(new GenerateRecurringInvoices)->daily();
        $schedule->job(new UpdateTenancyRentBalances)->daily();
        $schedule->job(new UpdateTenancyDepositBalances)->daily();

        // if ($time = get_setting('statement_send_time')) {
        //     $schedule->job(new SendUnsentStatements)->dailyAt($time);
        // }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
