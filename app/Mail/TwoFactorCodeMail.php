<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $name;

    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mã xác thực hai lớp - WebChoThu',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.two-factor-code',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
