<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendUnsentStatements implements ShouldQueue
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
        // Get a collection of unsent statements.
        $statements = Statement::whereNull('sent_at')->get();
        
        foreach ($statements as $statement) {
            // Check to make sure that the statement can be sent.
            if ($statement->canBeSent()) {
                // Send the statement.
                $statement->send();
            }
        }
    }
}
