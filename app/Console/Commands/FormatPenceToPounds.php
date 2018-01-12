<?php

namespace App\Console\Commands;

use App\Expense;
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
        $records = Expense::all();

        foreach ($records as $record) {
            $record->update([
                'cost' => $record->cost / 100,
            ]);
        }

        $this->info('Updated Records');
    }
}
