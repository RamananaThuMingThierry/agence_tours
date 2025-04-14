<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\TestimonialServices;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TestimonialRequest;

class TestimonialsController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialServices $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {

                $testimonials = $this->testimonialService->getAllTestimonials();

                $testimonials->map(function ($testimonial) {
                    $testimonial->encrypted_id = Crypt::encryptString($testimonial->id);
                    unset($testimonial->id);
                    return $testimonial;
                });

                return DataTables::of($testimonials)
                    ->addColumn('image', function ($row) {
                        $src = asset(config('public_path.public_path').'images/testimonials/'.$row->image);
                        return '<img src="' . $src . '" data-src="'.$src.'" class="rounded-2 testimonial-image" width="30" height="30" style="cursor: pointer;" alt="Image">';
                    })
                    ->addColumn('action', function ($row) {
                        $showBtn = '<button type="button"
                            class="btn btn-outline-warning btn-sm btn-inline me-1"
                            title="Voir les détails"
                            data-id="' . $row->encrypted_id . '"
                            id="btn-show-testimonial">
                            <i class="fa fa-eye"></i>
                        </button>';

                        $editBtn = '<button type="button"
                                        class="btn btn-outline-primary btn-sm btn-inline me-1"
                                        title="Modifier le testimonial"
                                        data-id="' . $row->encrypted_id . '"
                                        data-status="' . $row->status . '"
                                        id="btn-edit-testimonial-modal">
                                        <i class="fa fa-edit"></i>
                                    </button>';

                        $deleteBtn = '';

                        if (Auth::check() && Auth::user()->isAdmin()) {
                            $deleteBtn = '<button type="button"
                                              class="btn btn-outline-danger btn-sm btn-inline me-1"
                                              title="Supprimer le temoignage"
                                              data-id="' . $row->encrypted_id . '"
                                              id="btn-delete-testimonial-confirm">
                                              <i class="fa fa-trash"></i>
                                          </button>';
                        }

                        return '<div class="d-flex justify-content-center">' . $showBtn . $editBtn . $deleteBtn . '</div>';
                    })
                    ->rawColumns(['image', 'action'])
                    ->make(true);
            }

            return view('backoffice.testimonials.index');

        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request)
    {
        try {
            $data = $request->validated();
    
            // Traitement de l'image si fournie
            if ($request->hasFile('image')) {
                $image      = $request->file('image');
                $imageName  = Str::slug($data['name']) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath  = public_path('images/testimonials');
    
                // Créer le dossier s'il n'existe pas
                if (!file_exists($imagePath)) {
                    mkdir($imagePath, 0755, true);
                }
    
                $image->move($imagePath, $imageName);
                $data['image'] = $imageName;
            }
    
            $this->testimonialService->createTestimonial($data);
    
            return response()->json([
                'status'  => true,
                'message' => __('testimonial.added'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => __('form.an_error_unknown'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $encrypted_id)
    {
        try {
            $id = Crypt::decryptString($encrypted_id);

            $testimonial = $this->testimonialService->getTestimonialById($id);
        
            return response()->json([
                'status' => true,
                'data' => [
                    'id'        => $testimonial->id,
                    'name'      => $testimonial->name,
                    'message'   => $testimonial->message,
                    'rating'    => $testimonial->rating,
                    'status'    => $testimonial->status,
                    'image'     => $testimonial->image
                        ? asset('images/testimonials/' . $testimonial->image)
                        : asset('images/empty.png'),
                    'created_at'=> $testimonial->created_at->format('d/m/Y H:i'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.not_found'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encrypted_id)
    {
        $request->validate([
            'status' => 'required|in:publish,archived'
        ]);
    
        try {
            $id = Crypt::decryptString($encrypted_id);

            $testimonial = $this->testimonialService->getTestimonialById($id);

            $testimonial->status = $request->status;
            
            $testimonial->save();
        
            return response()->json([
                'status' => true,
                'message' => __('testimonial.updated')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.not_found'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encrypted_id)
    {
        try{
            $id = Crypt::decryptString($encrypted_id);

            $testimonial = $this->testimonialService->getTestimonialById($id);

            // Supprimer l'image du disque
            if ($testimonial->image && file_exists(public_path('images/testimonials/' . $testimonial->image))) {
                unlink(public_path('images/testimonials/' . $testimonial->image));
            }
        
            $testimonial->delete();
        
            return response()->json([
                'status' => true,
                'message' => __('testimonial.deleted')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('form.not_found'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
