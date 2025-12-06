<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $email;
    public ?string $phone;
    public string $subjectType;
    public string $messageContent;
    public bool $newsletter;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $email, ?string $phone, string $subjectType, string $messageContent, bool $newsletter = false)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->subjectType = $subjectType;
        $this->messageContent = $messageContent;
        $this->newsletter = $newsletter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectLabels = [
            'general' => 'Thông tin chung',
            'rental' => 'Tư vấn thuê thiết bị',
            'support' => 'Hỗ trợ kỹ thuật',
            'partnership' => 'Hợp tác kinh doanh',
            'other' => 'Khác',
        ];

        $subjectLabel = $subjectLabels[$this->subjectType] ?? 'Liên hệ từ website';

        return new Envelope(
            subject: "[WebChoThu] {$subjectLabel} - {$this->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
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

