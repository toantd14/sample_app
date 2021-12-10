<?php

namespace Modules\Owner\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailRegister extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;

    public function __construct($mailConfig)
    {
        $this->data = $mailConfig;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('owner::mails.mail_register')
            ->from(config('constants.MAIL_NO_REPLY'))
            ->subject(config('constants.SUBJECT_MAIL_REGISTER'))
            ->with([
                'url' => $this->data['url'],
                'code' => $this->data['code']
            ]);
    }
}
