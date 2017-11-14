<?php

namespace App\Console\Commands;

use App\Jobs\ArchivePastTenancyRents;
use Illuminate\Console\Command;

class ArchiveTenancyRents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:archive-rents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for any tenancy rents that need to be archived';

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
        ArchivePastTenancyRents::dispatch();
    }
}
