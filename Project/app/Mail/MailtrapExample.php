<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MailtrapExample extends Mailable
{
    // Necessary to pass data from the controller.
    public $mailData;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        // Necessary to pass data from the controller.
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('jane.doe@example.com', 'Jane Doe'),
            subject: 'Mailtrap Example',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.welcome',
        );
    }

    public function build()
    {
        return $this->subject('Order status updated')
                    ->view('emails.orderstateUpdate', ['mailData' => $this->mailData]);
    }

}
