<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MailAccountDeletionConfirmation extends Mailable
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
        $text = 'User id:' . Auth::id() . ' sent a request to delete an account';
        //Account deletion request
        return $this->subject('Message from BeMyCoFounder.com')
            ->view('emails.account_deletion_request')->with(['text' => $text, 'title' => 'Account deletion request']);
    }
}
