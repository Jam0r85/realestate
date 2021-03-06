<?php

namespace App\Console\Commands;

use App\Tenancy;
use Illuminate\Console\Command;

class TenancyUpdateNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:update-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach (Tenancy::withTrashed()->get() as $tenancy) {
            $tenancy
                ->setName()
                ->save();
        }

        $this->info('Tenancy names were updated');
    }
}
