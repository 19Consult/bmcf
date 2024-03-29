<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTestTemplateBlade extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Message from BeMyCoFounder.com';
        if(isset($this->data['subject']) && !empty($this->data['subject'])){
            $subject = $this->data['subject'];
        }

        return $this->subject($subject)->view('emails.test')->with(['data' => $this->data]);
    }
}
