<?php

namespace App\Console\Commands;

use App\Tenancy;
use Illuminate\Console\Command;

class TenancyUpdateRentBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:update-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the balances for all tenancies';

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
        $tenancies = Tenancy::all();

        foreach ($tenancies as $tenancy) {
            $tenancy->rent_balance = $tenancy->present()->rentBalancePlain;
            $tenancy->save();
        }

        $this->info('Tenancies updated');
    }
}
