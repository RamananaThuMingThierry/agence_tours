<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Services\GallerieServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\GalleryRequest;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\VarDumper\Cloner\Data;

class GalleriesController extends Controller
{
    private $gelleryService;

    public function __construct(GallerieServices $gelleryService)
    {
        $this->gelleryService = $gelleryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $galleries = $this->gelleryService->getAllGalleries(['id','image_url','status']);

            if ($request->ajax()) {
                $galleries = $this->gelleryService->getAllGalleries(['id','image_url','status']);

                return DataTables::of($galleries)
                    ->addColumn('image_url', function ($row) {
                        $src = asset(config('public_path.public_path').'galleries/'.$row->image_url);
                        return '<img src="' . $src . '" data-src="'.$src.'" class="rounded-2 gallery-image" width="30" height="30" style="cursor: pointer;" alt="Image">';
                    })
                    ->addColumn('action', function ($row) {
                        $editBtn = '<button type="button"
                                        class="btn btn-outline-primary btn-sm btn-inline me-1"
                                        title="Modifier le statut"
                                        data-id="' . $row->id . '"
                                        data-status="' . $row->status . '"
                                        id="btn-edit-gallery-modal">
                                        <i class="fa fa-edit"></i>
                                    </button>';

                        $deleteBtn = '';

                        if (Auth::check() && Auth::user()->isAdmin()) {
                            $deleteBtn = '<button type="button"
                                              class="btn btn-outline-danger btn-sm btn-inline ms-1"
                                              title="Supprimer l\'image"
                                              data-id="' . $row->id . '"
                                              id="btn-delete-gallery-confirm">
                                              <i class="fa fa-trash"></i>
                                          </button>';
                        }

                        return '<div class="d-flex justify-content-center">' . $editBtn . $deleteBtn . '</div>';
                    })
                    ->rawColumns(['image_url', 'action'])
                    ->make(true);
            }

            return view('backoffice.galleries.index');

        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryRequest $request)
    {
        $data = $request->validated();

        $image_url = $request->file('image_url');
        $imageName = time() . '.' . $image_url->getClientOriginalExtension();
        $image_url->move(public_path('galleries'), $imageName);
        $data['image_url'] = $imageName;

        Gallery::create($data);

        return response()->json(['message' => __('gallery.image_added')], 201);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:publish,archived'
        ]);

        $gallery = Gallery::findOrFail($id);
        $gallery->status = $request->status;
        $gallery->save();

        return response()->json(['message' => __('gallery.status_updated')]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return response()->json(['message' => __('gallery.deleted')]);
    }

}
