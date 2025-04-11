<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RecaptchaFailedNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🚨 Alerte : Tentative suspecte détectée sur reCAPTCHA')
            ->line('Une tentative de connexion a échoué à cause d’un score reCAPTCHA trop bas.')
            ->line('Détails :')
            ->line('📧 Email : ' . $this->data['email'])
            ->line('📍 IP : ' . $this->data['ip'])
            ->line('🏠 Hostname : ' . $this->data['hostname'])
            ->line('⭐ Score reCAPTCHA : ' . $this->data['score'])
            ->line('Si cela semble suspect, vérifiez les journaux de votre site.')
            ->salutation('Cordialement, votre système de surveillance.');
    }
}

