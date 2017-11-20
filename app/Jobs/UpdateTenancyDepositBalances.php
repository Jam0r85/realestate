<?php

namespace App\Jobs;

use App\Tenancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTenancyDepositBalances
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The ID of the tenancy we are updating.
     * 
     * @var integer
     */
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

            if ($tenancy->deposit) {
                $tenancy->deposit->update([
                    'balance' => $tenancy->deposit->balance
                ]);
            }
        }

        if (is_null($this->tenancy_id)) {
            $tenancies = Tenancy::get();
            foreach ($tenancies as $tenancy) {
                if ($tenancy->deposit) {
                    $tenancy->deposit->update([
                        'balance' => $tenancy->deposit->balance
                    ]);
                }
            }
        }
    }
}
