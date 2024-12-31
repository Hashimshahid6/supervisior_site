<?php

namespace App\Mail;

use App\Models\PlantChecklist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class PlantChecklistMail extends Mailable
{
    use Queueable, SerializesModels;

    public $checklistDetails;
    public $pdfPath;
    public $Days;
    public $PlantChecklists;
    public $PlantTypes;

    /**
     * Create a new message instance.
     */
    public function __construct($checklistDetails, string $pdfPath, $Days, $PlantChecklists, $PlantTypes)
    {
        $this->checklistDetails = $checklistDetails;
        $this->pdfPath = $pdfPath;
        $this->Days = $Days;
        $this->PlantChecklists = $PlantChecklists;
        $this->PlantTypes = $PlantTypes;
        $this->subject('Plant Checklist Mail');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Plant Checklist Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.plant_checklist', // Blade file for the email content
            with: ['DailyChecklist' => $this->checklistDetails, 
            'Days' => $this->Days,
            'PlantChecklists' => $this->PlantChecklists,
            'PlantTypes' => $this->PlantTypes]
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
                ->as('Plant_Checklist.pdf')
                ->withMime('application/pdf'),
        ];
    }
}