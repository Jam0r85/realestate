<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BaseMailer extends Mailable
{
	use Queueable, SerializesModels;

	public function __construct()
	{
		$this->from([
            'address' => get_setting('company_email'),
            'name' => get_setting('company_name')
        ]);
	}
}