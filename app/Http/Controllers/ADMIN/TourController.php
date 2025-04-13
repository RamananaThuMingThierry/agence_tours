<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use Illuminate\Http\Request;
use App\Services\TourServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TourController extends Controller
{
    private $tourService;

    public function __construct(TourServices $tourService)
    {
        $this->tourService = $tourService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if($request->ajax()){

                $tours = $this->tourService->getAllTours();

                return DataTables::of($tours)
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

            return view('backoffice.tours.index');

        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
