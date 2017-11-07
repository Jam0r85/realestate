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

class SendStatementToOwners 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The statement we are sending.
     * 
     * @var \App\Statement
     */
    public $statement;

    /**
     * Delay time in sending the notification
     * 
     * @var \Carbon\Caron
     */
    public $delay;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
        $this->delay = Carbon::now()->addMinutes(30);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the notification to the users of the statement.
        foreach ($this->statement->users as $user) {
            $user->notify(new StatementSentNotification($this->statement, $user));
        }
    }
}
