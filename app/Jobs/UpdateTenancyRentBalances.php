<?php

namespace App\Jobs;

use App\Tenancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTenancyRentBalances
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tenancy_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tenancy_id = null)
    {
        $this->tenancy_id = $tenancy_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->tenancy_id) {
            $tenancy = Tenancy::findOrFail($this->tenancy_id);
            $tenancy->update([
                'rent_balance' => $tenancy->present()->rentBalancePlain
            ]);
        }

        if (is_null($this->tenancy_id)) {
            $tenancies = Tenancy::get();
            foreach ($tenancies as $tenancy) {
                $tenancy->update([
                    'rent_balance' => $tenancy->present()->rentBalancePlain
                ]);
            }
        }
    }
}
