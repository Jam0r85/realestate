<?php

namespace App\Console\Commands;

use App\Property;
use Illuminate\Console\Command;

class CovertPropertySettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'property:convert-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert settings from the settings table to the property settings field';

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
        $properties = Property::get();

        foreach ($properties as $property) {

            if ($property->hasSetting('post_rental_statement')) {
                $data['statement_send_method'] = 'post';
            } else {
                $data['statement_send_method'] = 'email';
            }

            $property->settings()->merge($data);
        }

        $this->info("Settings merged");
    }
}
