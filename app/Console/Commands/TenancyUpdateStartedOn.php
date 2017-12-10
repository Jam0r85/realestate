<?php

namespace App\Console\Commands;

use App\Tenancy;
use Illuminate\Console\Command;

class TenancyUpdateStartedOn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:update-started';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all tenancy started on dates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Tenancy::all() as $tenancy) {

            // Get the started date from the first agreement or set it to null if none present
            $started = $tenancy->firstAgreement ? $tenancy->firstAgreement->starts_at : null;

            // Does the new started at date match the one set? If not we update it
            if ($tenancy->started_on != $started) {
                $tenancy->started_on = $started;
                $tenancy->save();
            }
        }

        $this->info('Tenancies updated');
    }
}
