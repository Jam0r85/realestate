<?php

namespace App\Console\Commands;

use App\Statement;
use Illuminate\Console\Command;

class UpdateStatementSendBy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statement:send-by';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the statements send_by method';

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
        $statements = Statement::all();

        foreach ($statements as $statement) {
            if ($statement->property->hasSetting('post_rental_statement')) {
                $statement->send_by = 'post';
            } else {
                $statement->send_by = 'email';
            }

            $statement->save();
        }
    }
}
