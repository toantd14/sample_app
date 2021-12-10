<?php

namespace Modules\Api\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailFeedback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($feedback)
    {
        $this->data = $feedback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('api::mails.mail_feedback')
            ->from(config('constants.MAIL_NO_REPLY'))
            ->subject(config('constants.SUBJECT_MAIL_FEEDBACK'))
            ->with([
                'feedback' => $this->data
            ]);
    }
}
