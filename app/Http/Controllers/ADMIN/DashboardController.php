<?php

namespace App\Http\Controllers\ADMIN;

use Carbon\Carbon;
use App\Models\Tour;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $monthlyReservations = Reservation::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->locale('fr')->translatedFormat('F');
            $data[] = $monthlyReservations[$i] ?? 0;
        }

        return view('backoffice.dashboard.index', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            'usersCount' => User::count(),
            'toursCount' => Tour::where('status', 'active')->count(),
            'reservationsCount' => Reservation::count(),
            'testimonialsCount' => Testimonial::count(),
            'latestReservations' => Reservation::latest()->take(5)->with('tour')->get(),
        ]);
    }

    // public function membre_card(){
    //     return response()->json([
    //         'membres' => Membre::where('sympathisant', false)->count(),
    //         'sympathisant' => Membre::where('sympathisant', true)->count(),
    //         'bureau' => Membre::where('type','bureau')->count(),
    //         'pending_members' => PendingMembre::where('statut', 'pending')->count()
    //     ]);
    // }

    // public function membres_chart(){
    //     $membres = Membre::selectRaw('DATE(date_inscription) as date, COUNT(*) as count')
    //     ->groupBy('date')
    //     ->orderBy('date', 'asc')
    //     ->get();
    //     return response()->json($membres);
    // }
}
