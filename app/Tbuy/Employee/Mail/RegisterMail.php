<?php

namespace App\Tbuy\Employee\Mail;

use App\Tbuy\Company\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string  $login,
        public readonly string  $password,
        public readonly Company $company
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('app.mail')),
            subject: 'Register',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.employee.register',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
