<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Slide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SlideServices;
use App\Http\Requests\SlideRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SlidesController extends Controller
{
    private $slideService;

    public function __construct(SlideServices $slideService){
        $this->slideService = $slideService;
    }

    public function normalizeOrder()
    {
        $slides = Slide::orderBy('order')->get();

        foreach ($slides as $index => $slide) {
            $slide->update(['order' => $index + 1]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {

                $slides = $this->slideService->getAllSlides();

                return DataTables::of($slides)
                    ->addColumn('image', function ($row) {
                        $src = asset(config('public_path.public_path').'images/slides/'.$row->image);
                        return '<img src="' . $src . '" data-src="'.$src.'" class="rounded-2 slide-image" width="30" height="30" style="cursor: pointer;" alt="Image">';
                    })
                    ->addColumn('action', function ($row) {
                        $showBtn = '<button type="button"
                            class="btn btn-outline-warning btn-sm btn-inline me-1"
                            title="Voir les détails"
                            data-id="' . $row->id . '"
                            id="btn-show-slide">
                            <i class="fa fa-eye"></i>
                        </button>';

                        $editBtn = '<button type="button"
                                        class="btn btn-outline-primary btn-sm btn-inline me-1"
                                        title="Modifier le slide"
                                        data-id="' . $row->id . '"
                                        data-status="' . $row->status . '"
                                        id="btn-edit-slide-modal">
                                        <i class="fa fa-edit"></i>
                                    </button>';

                        $deleteBtn = '';

                        if (Auth::check() && Auth::user()->isAdmin()) {
                            $deleteBtn = '<button type="button"
                                              class="btn btn-outline-danger btn-sm btn-inline"
                                              title="Supprimer l\'image"
                                              data-id="' . $row->id . '"
                                              id="btn-delete-slide-confirm">
                                              <i class="fa fa-trash"></i>
                                          </button>';
                        }

                        return '<div class="d-flex justify-content-center">' . $showBtn . $editBtn . $deleteBtn . '</div>';
                    })
                    ->rawColumns(['image', 'action'])
                    ->make(true);
            }

            return view('backoffice.slides.index');

        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlideRequest $request)
    {
        try {
            // Vérifier si le nombre de slides existants est déjà à 4
            if (Slide::count() >= 4) {
                return response()->json([
                    'status' => false,
                    'message' => __('slide.limit_reached') // à traduire dans lang files
                ], 422);
            }

            $data = $request->validated();

            // Gestion de l'image
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '-' . Str::slug($data['title']) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/slides'), $imageName);
                $data['image'] = $imageName;
            }

            // Création du slide
            Slide::create($data);

            return response()->json([
                'status' => true,
                'message' => __('slide.added'), // à traduire aussi
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.an_error_unknown'),
                'error' => $e->getMessage()
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

    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        return response()->json($slide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SlideRequest $request, $id)
    {
        try {
            $slide = Slide::findOrFail($id);

            $data = $request->only('title', 'subtitle', 'description', 'order');

            // Gérer l'image si elle existe
            if ($request->hasFile('image')) {
                $oldPath = public_path('images/slides/' . $slide->image);
                if (file_exists($oldPath)) unlink($oldPath);

                $image = $request->file('image');
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/slides'), $imageName);

                $data['image'] = $imageName;
            }

            $slide->update($data);

            return response()->json([
                'status' => true,
                'message' => __('slide.status_updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.an_error_unknown'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $slide = Slide::findOrFail($id);

            // Supprimer le fichier image du dossier public
            $imagePath = public_path('images/slides/' . $slide->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $slide->delete();

            return response()->json([
                'status' => true,
                'message' => __('slide.deleted')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('alerts.delete_failed'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
