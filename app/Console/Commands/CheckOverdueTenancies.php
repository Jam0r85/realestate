<?php

namespace App\Console\Commands;

use App\Repositories\EloquentTenanciesRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOverdueTenancies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prop:overdue-tenancies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all managed tenancies and check whether overdue or not.';

    /**
     * @var App\Repositories\EloquentTenanciesRepository.
     */
    public $tenancies;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EloquentTenanciesRepository $tenancies)
    {
        parent::__construct();

        $this->tenancies = $tenancies;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->tenancies->getAll() as $tenancy) {
            if ($tenancy->service_charge_amount > 0) {
                if ($tenancy->next_statement_start_date <= Carbon::now()) {
                    $tenancy->update(['is_overdue' => true]);
                } else {
                    $tenancy->update(['is_overdue' => false]);
                }
            }
        }

        $this->info('Tenancies processed');
    }
}
