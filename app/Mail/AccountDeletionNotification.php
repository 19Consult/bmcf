<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDeletionNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = 'Your account has been successfully deleted.';
        //Account deletion request
        return $this->subject('Message from BMCF')
            ->view('emails.account_deletion_request')->with(['text' => $text, 'title' => 'Account deletion request']);
    }
}
