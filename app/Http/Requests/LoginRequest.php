<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\RecaptchaFailedNotification;

class LoginRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation appliquées à la requête.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ];
    }

    /**
     * Personnalisation des messages d'erreur.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
            'g-recaptcha-response.required' => 'Veuillez valider le reCAPTCHA.',
        ];
    }

    /**
     * Validation supplémentaire après les règles initiales.
     */
    protected function passedValidation()
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'), // Assure-toi que cette clé est correcte
            'response' => $this->input('g-recaptcha-response'),
            'remoteip' => $this->ip(),
        ]);

        $responseData = $response->json();

        if (!$responseData['success'] || $responseData['score'] < 0.5) {
            
            // 🔥 Enregistre l’échec et envoie une alerte par e-mail
            $data = [
                'ip' => $this->ip(),
                'email' => $this->input('email'),
                'score' => $responseData['score'] ?? 'N/A',
                'hostname' => $responseData['hostname'] ?? 'N/A',
            ];

            Log::warning('Échec de la vérification reCAPTCHA', $data);

            // Envoyer une notification par email aux administrateurs
            Notification::route('mail', 'antatech.solutions@gmail.com')->notify(new RecaptchaFailedNotification($data));

            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Échec de la vérification reCAPTCHA. Veuillez réessayer.'
            ]);
        }
    }
}
