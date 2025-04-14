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
use Illuminate\Support\Facades\File;
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
                            <a href="javascript:void(0)"
                            class="btn btn-outline-danger btn-sm btn-inline ms-1 btn-delete-tour"
                            title="Supprimer un tour"
                            data-id="' . $row->encrypted_id . '">
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
    public function edit(string $encrypted_id)
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

            return view('backoffice.tours.form', compact('tour'));
        }catch(Exception $e){
            return redirect()->route('admin.tours.index')->with('error', 'Erreur : ID invalide ou corrompu. Veuillez réesayer');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TourRequest $request, $encrypted_id)
    {
        try {
            $id = Crypt::decryptString($encrypted_id);
            $tour = $this->tourService->getTourById($id);

            if (!$tour) {
                return response()->json([
                    'status' => 404,
                    'message' => __('tour.tour_not_found')
                ], 404);
            }

            $validatedData = $request->validated();

            // Traiter les images si présentes
            $images = null;
            if ($request->hasFile('images')) {
                $images = $request->file('images'); // plus clair que $validatedData['images']
            }

            // Si aucune nouvelle image et aucune existante
            if (!$images && $tour->images->isEmpty()) {
                return response()->json([
                    'status' => 422,
                    'errors' => [
                        'images' => [__('tour.please_add_at_least_one_image')]
                    ]
                ], 422);
            }

            // Génération du slug si le titre a changé
            if (isset($validatedData['title'])) {
                $slug = Str::slug($validatedData['title']);
                $originalSlug = $slug;
                $counter = 1;

                while (\App\Models\Tour::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $validatedData['slug'] = $slug;
            }

            // Mettre à jour le tour
            $this->tourService->updateTour($id, $validatedData);

            // Gérer les nouvelles images
            if ($images) {
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $imageName = Str::slug($tour->title) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('images/tours'), $imageName);

                        $tour->images()->create([
                            'image' => $imageName,
                            'tour_id' => $tour->id,
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => __('tour.update_success')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => __('tour.update_error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptedId)
    {
        try {
            // 🔐 Décrypter l’ID
            $id = Crypt::decryptString($encryptedId);

            // 🔎 Récupérer le tour avec ses images
            $tour = $this->tourService->getTourById($id);

            if (!$tour) {
                return response()->json([
                    'status' => false,
                    'message' => __('tour.tour_not_found'),
                ], 404);
            }

            // 🗑 Supprimer les fichiers images du dossier
            foreach ($tour->images as $image) {
                $imagePath = public_path('images/tours/' . $image->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                // Supprimer de la BDD
                $image->delete();
            }

            // 🧹 Soft delete (ou hard delete si tu préfères)
            $tour->delete();

            return response()->json([
                'status' => true,
                'message' => __('tour.delete_success')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.delete_error'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
