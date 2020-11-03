<?php

namespace App\Mail;

use App\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    public Mail $mail;

    /**
     * Create a new message instance.
     *
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('mails.notification')->with('mail', $this->mail);
        return $this->from(getConfiguration('text', 'MAIL_USERNAME'))
            ->subject($this->mail->subject)//'Activación de cuenta'
            ->view('mails.notification')
            ->with('mailing', $this->mail->body);
    }
}
