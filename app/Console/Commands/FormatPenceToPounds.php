<?php

namespace App\Console\Commands;

use App\Payment;
use Illuminate\Console\Command;

class FormatPenceToPounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'format:pence-to-pounds';

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
        $payments = Payment::all();

        foreach ($payments as $payment) {
            $payment->update(['amount' => $payment->amount / 10]);
        }

        $this->info('Updated Payments');
    }
}
