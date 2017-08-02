<?php

namespace App\Console\Commands;

use App\Repositories\EloquentStatementsRepository;
use Illuminate\Console\Command;

class SendUnsentStatements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statement:send-unsent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all the unset statements.';

    /**
     * \App\Repositories\EloquentStatementsRepository
     */
    public $statements;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EloquentStatementsRepository $statements)
    {
        parent::__construct();
        $this->statements = $statements;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get an array of statement id's which have not been sent yet.
        $ids = $this->statements->getUnsentList()->pluck('id');

        if (count($ids)) {
            $this->statements->sendStatementsWithChecks($ids);
            $this->info(count($ids) . ' were assigned to be sent');
        } else {
            $this->info('No unsent statements found');
        }
    }
}
