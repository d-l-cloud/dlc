<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class formMailSend extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $subject)
    {
        $this->details = $details;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->bcc('123@doorlock.ru', 'Смирнову Вадиму')
            ->markdown('emails.formMailSend')
            ->with('details', $this->details);
    }
}
