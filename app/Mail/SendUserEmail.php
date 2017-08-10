<?php

namespace App\Mail;

class SendUserEmail extends BaseMailer
{
    /**
     * The email subject
     * 
     * @var string
     */
    public $subject;

    /**
     * The email body message.
     * 
     * @var string
     */
    public $body;

    /**
     * The files to attach to the email.
     * 
     * @var array
     */
    public $files;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $files = [])
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Loop through any attachments and attach them to the email.
        if (count($this->files)) {
            foreach ($this->files as $file) {
                $this->attach($file->getRealPath(), [
                    'as' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType()
                ]);
            }
        }

        return $this->markdown('email-templates.user-message');
    }
}
