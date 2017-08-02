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
    protected $description = 'Loop through unsent statements and send them.';

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
        $statement_ids = $this->statements->getUnsentList()->pluck('id');

        if (count($statement_ids)) {
            $this->statements->sendStatementsWithChecks($statement_ids);
            $this->info(count($ids) . ' were assigned to be sent');
        } else {
            $this->info('No unsent statements found');
        }
    }
}
