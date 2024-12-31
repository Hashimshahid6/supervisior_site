<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ToolboxTalkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $toolboxTalk;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($toolboxTalk, string $pdfPath)
    {
        $this->toolboxTalk = $toolboxTalk;
        $this->pdfPath = $pdfPath;
        $this->subject('Toolbox Talk Mail');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Toolbox Talk Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.toolbox_talks', // Blade file for the email content
            with: ['toolboxTalk' => $this->toolboxTalk,
            'pdfPath' => $this->pdfPath]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)
                ->as('Toolbox_Talk_Template.pdf')
                ->withMime('application/pdf'),
        ];
    }
}