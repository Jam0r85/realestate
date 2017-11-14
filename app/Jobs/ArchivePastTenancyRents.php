<?php

namespace App\Jobs;

use App\TenancyRent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArchivePastTenancyRents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all tenancy rents where the starts_at date is less than today
        $rents = TenancyRent::where('starts_at', '<', Carbon::now())->get();

        if (count($rents)) {
            foreach ($rents as $rent) {

                // Check whether the tenancy has another rent amount that starts today.
                $new_rent = TenancyRent::where('id', '!=', $rent->id)
                    ->where('tenancy_id', $rent->tenancy_id)
                    ->where('starts_at', '<=', Carbon::now())
                    ->oldest('starts_at')
                    ->first();

                if ($new_rent) {
                    $rent->delete();
                }
            }
        }
    }
}
