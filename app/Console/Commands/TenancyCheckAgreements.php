<?php

namespace App\Console\Commands;

use App\Agreement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TenancyCheckAgreements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:check-agreements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update tenancy agreements';

    /**
     * The agreements repository we are dealing with.
     * 
     * @var \App\Agreement
     */
    public $agreements;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Agreement $agreements)
    {
        parent::__construct();
        $this->agreements = $agreements;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all non archived agreements
        $agreements = $this->agreements->get();

        if (count($agreements)) {
            foreach ($agreements as $agreement) {

                // Archive agreements which have ended
                if ($agreement->ends_at && $agreement->ends_at < Carbon::now()) {
                    $agreement->delete();
                }

                // Get all other agreements for this tenancy
                $otherAgreements = $this->agreements
                    ->where('id', '!=', $agreement->id) // we want other agreements
                    ->where('tenancy_id', $agreement->tenancy_id) // with the same tenancy
                    ->get();

                if (count($otherAgreements)) {
                    foreach ($otherAgreements as $otherAgreement) {

                        // Has the other agreement met its start date?
                        if ($otherAgreement->starts_at <= Carbon::now()) {
                            // Is the other agreement's start date bigger than the current agreements start date?
                            if ($otherAgreement->starts_at > $agreement->starts_at) {
                                $agreement->delete();
                            }
                        }
                    }
                }
            }
        }

        $this->info('Tenancy Agreements Checked');
    }
}
