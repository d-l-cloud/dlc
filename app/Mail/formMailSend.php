<?php

namespace App\Mail;

use App\Models\Site\SiteSettings;
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
        $findesiteSettings = SiteSettings::where('id', '=', 1)->first();
        if ($findesiteSettings){
            $fromName = ' - '.$findesiteSettings->city.' | ';
        }else {
            $fromName = '';
        }
        return $this->subject($this->subject)
            ->from(env('MAIL_FROM_ADDRESS'), 'Doorlock'.$fromName.'Почтовый робот '.date('H:i:s d-m-Y').'')
            ->bcc('123@doorlock.ru', 'Смирнову Вадиму')
            ->markdown('emails.formMailSend')
            ->with('details', $this->details);
    }
}
