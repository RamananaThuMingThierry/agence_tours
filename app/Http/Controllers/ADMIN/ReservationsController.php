<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Events\ReservationCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ReservationServices;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ReservationRequest;

class ReservationsController extends Controller
{
    private $reservationService;

    public function __construct(ReservationServices $reservationService)
    {
        $this->reservationService = $reservationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if($request->ajax()){

                $reservations = $this->reservationService->getAllReservations();

                $reservations->map(function ($reservation) {
                    $reservation->encrypted_id = Crypt::encryptString($reservation->id);
                    unset($reservation->id);
                    return $reservation;
                });

                return DataTables::of($reservations)
                    ->addColumn('action', function ($row) {
                        $viewBtn = '<button type="button"
                            class="btn btn-outline-warning btn-sm btn-inline"
                            title="' . __('form.seen') . '"
                            data-id="' . $row->encrypted_id . '"
                            id="btn-show-reservation">
                            <i class="fa fa-eye"></i>
                        </button>';
                        $deleteBtn = '';
                        if (Auth::check() && Auth::user()->isAdmin()) {
                            $deleteBtn = '<button type="button"
                                            class="btn btn-outline-danger btn-sm btn-inline ms-1"
                                            title="Supprimer la réservation"
                                            data-id="' . $row->encrypted_id . '"
                                            id="btn-delete-reservation-confirm">
                                            <i class="fa fa-trash"></i>
                                        </button>';
                        }

                        return '<div class="d-flex justify-content-center">' . $viewBtn . $deleteBtn . '</div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backoffice.reservations.index');

        }catch (Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'pending';
    
        try {
            $reservation = $this->reservationService->createReservation($data);
    
            // ✉️ Envoi automatique à l'admin
            event(new ReservationCreated($reservation));
            
            // 📲 Redirection vers WhatsApp
            $whatsappNumber = '261380913703'; // Numéro de l'admin
            $clientMessage = "Bonjour, je viens de réserver un tour via le site. Voici mes informations:\n"
                . "Nom: {$data['name']}\n"
                . "Email: {$data['email']}\n"
                . "Téléphone: {$data['phone']}\n"
                . "Message: {$data['message']}";
    
            $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($clientMessage);
    
            return response()->json([
                'status' => true,
                'redirect_url' => $whatsappUrl,
            ]);
    
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating the reservation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try {
            $id = Crypt::decryptString($encrypted_id);
            $reservation = Reservation::with('tour')->findOrFail($id);

            if ($reservation->status === 'pending') {
                $reservation->update(['status' => 'seen']);
            }

            return response()->json([
                'status' => true,
                'data' => $reservation
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération des détails.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encrypted_id)
    {
        try {
            $id = Crypt::decryptString($encrypted_id);
            $reservation = Reservation::findOrFail($id);

            if (!auth()->user() || !auth()->user()->isAdmin()) {
                return response()->json([
                    'status' => false,
                    'message' => __('form.unauthorized')
                ], 403);
            }

            $reservation->delete();

            return response()->json([
                'status' => true,
                'message' => __('reservation.deleted')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.delete_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
