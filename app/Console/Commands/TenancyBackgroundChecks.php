<?php

namespace App\Console\Commands;

use App\Repositories\EloquentTenanciesRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TenancyBackgroundChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancies:background-checks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all managed tenancies and update background details.';

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
            if ($tenancy->isManaged()) {

                // Check whether tenancy is overdue
                if ($tenancy->next_statement_start_date <= Carbon::now()) {
                    $tenancy->fill(['is_overdue' => true]);
                } else {
                    $tenancy->fill(['is_overdue' => false]);
                }

                $tenancy->save();
            }
        }

        $this->info('Tenancies processed');
    }
}
