<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BadgeController extends Controller
{
    public function getAll(){
        $cacheKey = 'all_data'; // Clé de cache
        $cacheTime = 60; // Temps en minutes

        $data = Cache::remember($cacheKey, $cacheTime, function () {
            return [
                // 'membres' => Membre::whereNull('deleted_at')->count(),
                // 'fonctions' => Fonction::whereNull('deleted_at')->count(),
                // 'groupes' => Groupe::whereNull('deleted_at')->count(),
                // 'users' => User::whereNull('deleted_at')->count(),
                // 'actualites' => Actualite::whereNull('deleted_at')->count(),
                // 'pending_membres' => PendingMembre::whereNull('deleted_at')->count()
            ];
        });

        return response()->json($data);
    }
}
