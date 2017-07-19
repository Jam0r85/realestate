<?php

namespace App\Mail;

use App\User;

class UserWelcomeEmail extends BaseMailer
{
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user-welcome')
            ->subject('Your new Steve Morris & Son account');
    }
}
