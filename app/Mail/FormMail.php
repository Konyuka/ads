<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class FormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $fname;
    public $lname;
    public $phone;
    public $email;
    public $messageContent;

    public function __construct($fname,$lname,$phone,$messageContent, $email)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->phone = $phone;
        $this->email = $email;
        $this->messageContent = $messageContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('ads@rochamn-properties.co.ke', 'Google Ads Lead'),
            subject: 'Customer Lead From Ads',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // return dd($request);
        return new Content(
            view: 'emails.plain'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
