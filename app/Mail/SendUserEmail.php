<?php

namespace App\Mail;

class SendUserEmail extends BaseMailer
{
    public $subject;
    public $body;
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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->subject);

        // Loop through any attachments and attach them to the email.
        if (count($this->files)) {
            foreach ($this->files as $file) {
                $mail->attach($file->getRealPath(), [
                    'as' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType()
                ]);
            }
        }

        return $mail->markdown('emails.user-message');
    }
}
