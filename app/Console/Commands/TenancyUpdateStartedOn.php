<?php

namespace App\Console\Commands;

use App\Tenancy;
use Carbon\Carbon;
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
        $tenancies = Tenancy::whereNull('started_on')->get();

        if (count($tenancies)) {
            foreach ($tenancies as $tenancy) {

                // Make sure the tenancy has a first agreement and that the start date has been passed
                if ($tenancy->firstAgreement && $tenancy->firstAgreement->starts_at <= Carbon::now()) {
                    $tenancy->update(['started_on' => $tenancy->firstAgreement->starts_at]);
                }
            }
        }

        $this->info('Checked tenancy started on dates');
    }
}
