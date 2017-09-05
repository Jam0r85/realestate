<?php

namespace App\Jobs;

use App\Mail\ErrorSendingStatement;
use App\Mail\StatementByEmail;
use App\Mail\StatementByPost;
use App\Statement;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendStatement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Statement
     */
    public $statement;

    /**
     * @var bool
     */
    public $sent;

    /**
     * Create a new job instance.
     *
     * @param  \App\Statement $statement
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
        /**
         * Build an array of e-mails to send the statement too.
         * @var array
         */
        $emails = [];

        /**
         * Loop through the statement users and get the emails.
         */
        if (count($this->statement->users)) {
            foreach ($this->statement->users as $user) {
                if ($user->email) {
                    $emails[] = $user->email;
                }
            }
        }

        if ($this->statement->sendByEmail()) {
            if (count($emails)) {
                Mail::to($emails)->send(
                    new StatementByEmail($this->statement)
                );
            } else {
                Mail::to(get_setting('company_email'))->send(
                    new ErrorSendingStatement($this->statement, 'missing-emails')
                );
                $this->resetSent();
            }
        }

        if ($this->statement->sendByPost()) {
            if ($this->statement->hasUserEmails()) {
                Mail::to($this->statement->getUserEmails())->send(
                    new StatementByPost($this->statement)
                );
            }
        }
    }

    /**
     * Update the statement as having been sent.
     * 
     * @return void
     */
    protected function resetSent()
    {
        $this->statement->sent_at = null;
        $this->statement->save();
    }
}
