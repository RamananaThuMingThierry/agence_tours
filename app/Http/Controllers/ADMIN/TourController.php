<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Tour;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TourServices;
use App\Http\Requests\TourRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
            $tours = $this->tourService->getAllTours();

            $tours->map(function ($tour) {
                $tour->encrypted_id = Crypt::encryptString($tour->id);
                unset($tour->id);
                return $tour;
            });

            if($request->ajax()){

                return DataTables::of($tours)

                ->addColumn('images', function ($tour) {

                    $firstImage = $tour->images->first();

                    if ($firstImage) {
                        return '<img src="'. asset(config('public_path.public_path').'images/tours/'.$firstImage->image) .'" alt="Image" width="50" height="50" class="rounded">';
                    }

                    return '<img src="' . asset(config('public_path.public_path').'images/empty.png') . '" alt="Image" width="50" height="50" class="rounded-pill">';
                })
                ->addColumn('action', function ($row) {
                    $viewEditButton = '<a href="/backoffice/tours/' . $row->encrypted_id . '" class="btn btn-outline-warning btn-sm btn-inline" title="Voir un tour">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="/backoffice/tours/' . $row->encrypted_id . '/edit" class="btn btn-outline-primary btn-sm btn-inline ms-1" title="Modifier un tour">
                                        <i class="fa fa-edit"></i>
                                    </a>';

                    $deleteButtons = '';
                    if (Auth::check() && Auth::user()->role == "admin") {
                        $deleteButtons = '
                            <a href="javascript:void(0)" type="button" class="btn btn-outline-danger btn-sm btn-inline ms-1" title="Supprimer un tour" id="btn-delete-tour-form-modal" data-id="' . $row->id . '">
                                <i class="fa fa-trash"></i>
                            </a>';
                    }

                    return '<div class="d-flex justify-content-center">' . $viewEditButton . $deleteButtons . '</div>';
                })
                ->rawColumns(['images','action'])
                ->make(true);
            }

            return view('backoffice.tours.index', compact('tours'));

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
        $tour = new Tour();
        return view('backoffice.tours.form', compact('tour'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TourRequest $request)
    {
        $validatedData = $request->validated();

        // Génération du slug unique
        $slug = Str::slug($validatedData['title']);
        $originalSlug = $slug;
        $counter = 1;

        // S'assurer que le slug est unique
        while (Tour::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validatedData['slug'] = $slug;

        // Traitement des images
        $images = null;
        if ($request->hasFile('images')) {
            $images = $validatedData['images'];
            unset($validatedData['images']);
        }

        $tour = $this->tourService->createTour($validatedData);

        if ($images != null) {
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $imageName = Str::slug($validatedData['title']) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/tours'), $imageName);

                    $tour->images()->create([
                        'image' => $imageName,
                        'tour_id' => $tour->id
                    ]);
                }
            }
        }

        return response()->json([
            'status'  => 200,
            'message' => __('tour.create_success'),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $encrypted_id)
    {
        try{
            $id = Crypt::decryptString($encrypted_id);

            $tour = $this->tourService->getTourById($id);

            if (!$tour) {
                abort(404);
            }

            // Réencrypte l'ID pour la vue
            $tour->encrypted_id = Crypt::encryptString($id);

            foreach ($tour->images as $image) {
                $image->encrypted_id = Crypt::encryptString($image->id);
            }

            return view('backoffice.tours.show', compact('tour'));
        }catch(Exception $e){
            return redirect()->route('admin.tours.index')->with('error', 'Erreur : ID invalide ou corrompu. Veuillez réesayer');
        }
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
