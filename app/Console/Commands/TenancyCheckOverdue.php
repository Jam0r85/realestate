<?php

namespace App\Console\Commands;

use App\Tenancy;
use Illuminate\Console\Command;

class TenancyCheckOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Searches through managed tenancies and marks them as overdue';

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
            $tenancy->setOverdue();
        }

        $this->info('Checked tenancy overdue');
    }
}
