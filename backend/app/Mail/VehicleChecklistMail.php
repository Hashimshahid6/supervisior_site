<?php

namespace App\Mail;

use App\Models\VehicleChecklist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class VehicleChecklistMail extends Mailable
{
    use Queueable, SerializesModels;

    public $checklistDetails;
    public $pdfPath;
    public $Days;
    public $VehicleItems;
    public $VehicleData;

    /**
     * Create a new message instance.
     */
    public function __construct($checklistDetails, string $pdfPath, $Days, $VehicleItems, $VehicleData)
    {
        $this->checklistDetails = $checklistDetails;
        $this->pdfPath = $pdfPath;
        $this->Days = $Days;
        $this->VehicleItems = $VehicleItems;
        $this->VehicleData = $VehicleData;
        $this->subject('Vehicle Checklist Mail');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vehicle Checklist Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vehicle_checklist', // Blade file for the email content
            with: ['DailyChecklist' => $this->checklistDetails, 
            'Days' => $this->Days,
            'VehicleItems' => $this->VehicleItems,
            'VehicleData' => $this->VehicleData
            ]
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
                ->as('Vehicle_Checklist.pdf')
                ->withMime('application/pdf'),
        ];
    }
}