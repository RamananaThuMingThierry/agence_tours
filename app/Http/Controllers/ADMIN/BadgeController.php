<?php

namespace App\Http\Controllers\ADMIN;

use App\Models\Tour;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Reservation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Support\Facades\Cache;

class BadgeController extends Controller
{
    public function getAll(){
        $cacheKey = 'all_data'; // Clé de cache
        $cacheTime = 60; // Temps en minutes

        $data = Cache::remember($cacheKey, $cacheTime, function () {
            return [
                'galleries' => Gallery::whereNull('deleted_at')->count(),
                'reservations' => Reservation::whereNull('deleted_at')->count(),
                'tours' => Tour::whereNull('deleted_at')->count(),
                'testimonials' => Testimonial::whereNull('deleted_at')->count(),
                'users' => User::whereNull('deleted_at')->count(),
                'slides' => Slide::whereNull('deleted_at')->count(),
            ];
        });

        return response()->json($data);
    }
}
