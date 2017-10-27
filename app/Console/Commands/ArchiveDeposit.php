<?php

namespace App\Console\Commands;

use App\Deposit;
use Illuminate\Console\Command;

class ArchiveDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive deposits based on if the tenancy has been archived';

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
        // Get all deposits with payments and where the tenancy has been soft deleted.
        $deposits = Deposit::select('id')
            ->whereHas('payments')
            ->whereHas('tenancy', function ($query) {
                $query->whereNotNull('deleted_at');
            })->get();

        foreach ($deposits as $deposit) {
            if ($deposit->balance == 0) {
                $deposit->delete();
            }
        }

        $this->info('The required deposits have been archived');
    }
}
