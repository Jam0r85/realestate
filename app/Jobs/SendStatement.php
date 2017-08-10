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
        if ($this->statement->sendByEmail()) {
            if (count($this->statement->getUserEmails())) {
                Mail::to($this->statement->getUserEmails())->send(
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
            if (count($this->statement->getUserEmails())) {
                Mail::to($this->statement->getUserEmails())->send(
                    new StatementByPost($this->statement)
                );
            }
        }
    }

    /**
     * The job failed to process.
     * 
     * @param  Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Mail::to(get_setting('company_email'))->send(
            new ErrorToUser($this->errorMessage())
        );
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
