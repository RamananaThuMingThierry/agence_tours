<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationMembre extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Confirmation de votre adhésion')
                    ->view('emails.confirmation_membre');
    }
}
