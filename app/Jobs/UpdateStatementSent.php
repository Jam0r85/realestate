<?php

namespace App\Jobs;

use App\Statement;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStatementSent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The statement we are updating.
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
        $this->statement->update(['sent_at' => Carbon::now()]);
    }
}
