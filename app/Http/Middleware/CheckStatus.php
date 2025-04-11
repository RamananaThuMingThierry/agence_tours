<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérification si l'utilisateur est authentifié
        if (Auth::check()) {
            
            // Si l'email n'est pas vérifié, rediriger vers la page de vérification
            if (Auth::user()->email_verified_at == null) {
                return redirect()->route('verification.notice');
            }
            
            // Vérification du statut et du rôle
            $user = Auth::user();
            if ($user->status === 'inactive' || $user->role == "user") {
                // Rediriger si le statut est inactif ou si l'utilisateur a un rôle de "user"
                return redirect()->route('status.not.approuved');
            }
            
            // Si l'utilisateur est actif et administrateur, autoriser la requête
            if ($user->status === 'active' && $user->role == "admin") {
                return $next($request);
            }
            
        } else {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return redirect()->route('login');
        }
    
    }
}
