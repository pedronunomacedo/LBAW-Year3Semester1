<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class MailtrapController extends Mailable
{
    // // Necessary to pass data from the controller.
    // public $mailData;


    // /**
    //  * Create a new message instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     // Necessary to pass data from the controller.
    // }

    // public function putMailData($mailData) {
    //     $this->mailData = $mailData;
    // }

    // /**
    //  * Get the message envelope.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Envelope
    //  */
    // public function envelope()
    // {
    //     return new Envelope(
    //         from: new Address('jane.doe@example.com', 'Jane Doe'),
    //         subject: 'Mailtrap Example',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Content
    //  */
    // public function content()
    // {
    //     return new Content(
    //         view: 'emails.welcome',
    //     );
    // }


    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        return $this->subject('Order status updated')
                    ->view('emails.orderstateUpdate', ['mailData' => $this->mailData]);
    }

}
