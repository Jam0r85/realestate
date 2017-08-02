<?php

namespace App\Jobs;

use Exception;
use App\Mail\ErrorToUser;
use App\Mail\StatementToLandlord;
use App\Statement;
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
        if (count($this->getEmails())) {
            // Send the statement by email.
            Mail::to($this->getEmails())->send(
                new StatementToLandlord($this->statement)
            );

            if (count(Mail::failures()) == 0) {
                $this->statement->setSent();
            }
        } else {
            $this->statement->setSent();
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
     * Get the emails of the owners that this statement is being sent to.
     * 
     * @return array
     */
    protected function getEmails()
    {
        $emails = [];

        if (count($this->statement->users)) {
            foreach ($this->statement->users as $user) {
                if ($user->email) {
                    $emails[] = $user->email;
                }
            }
        }

        return $emails;
    }

    /**
     * The error message should the job fail to process.
     * 
     * @return [type] [description]
     */
    protected function errorMessage()
    {
        return 'There was an error sending statement #' . $this->statement->id . ' to the owners by e-mail either because the e-mail failed to send or no e-mail was provided';
    }
}
