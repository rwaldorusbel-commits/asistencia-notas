<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\User;

use Illuminate\Support\Facades\Mail;

class AvisoGeneral extends Mailable
{
    public function __construct(public string $mensaje) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Aviso del Sistema de Notas');
    }

    public function content(): Content
    {
        return new Content(htmlString: '<p>' . e($this->mensaje) . '</p>');
    }
}
