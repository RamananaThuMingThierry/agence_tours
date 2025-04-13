<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\ReservationServices;
use Yajra\DataTables\Facades\DataTables;
use Exception;

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

                $reservations = $this->reservationService->getAllReservations(['id','name','email','phone','status']);

                return DataTables::of($reservations)
                    // ->addColumn('action', function ($row) {
                    //     $editBtn = '<button type="button"
                    //                     class="btn btn-outline-primary btn-sm btn-inline me-1"
                    //                     title="Modifier le statut"
                    //                     data-id="' . $row->id . '"
                    //                     id="btn-edit-reservation-modal">
                    //                     <i class="fa fa-edit"></i>
                    //                 </button>';

                    //     $deleteBtn = '';

                    //     if (Auth::check() && Auth::user()->isAdmin()) {
                    //         $deleteBtn = '<button type="button"
                    //                         class="btn btn-outline-danger btn-sm btn-inline ms-1"
                    //                         title="Supprimer la réservation"
                    //                         data-id="' . $row->id . '"
                    //                         id="btn-delete-reservation-confirm">
                    //                         <i class="fa fa-trash"></i>
                    //                     </button>';
                    //     }

                    //     return '<div class="d-flex justify-content-center">' . $editBtn . $deleteBtn . '</div>';
                    // })
                    // ->rawColumns(['action'])
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

        $data['tour_id'] = 1;
        $data['status'] = 'pending';

        try {
            $reservation = $this->reservationService->createReservation($data);

            return response()->json([
                'status' => true,
                'message' => __('reservation.created'),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('An error occurred while creating the reservation.'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
