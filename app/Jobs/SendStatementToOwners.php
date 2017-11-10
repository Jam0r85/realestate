<?php

namespace App\Jobs;

use App\Notifications\StatementSentNotification;
use App\Statement;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendStatementToOwners implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The statement we are sending.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->statement->users, new StatementSentNotification($this->statement));
    }
}
