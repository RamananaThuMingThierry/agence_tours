<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('backoffice.dashboard.index');
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
