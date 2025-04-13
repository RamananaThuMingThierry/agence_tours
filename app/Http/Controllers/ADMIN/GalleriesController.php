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
                        return '<img src="' . asset(config('public_path.public_path').'galleries/'.$row->image_url) . '" alt="Image" width="30" height="30" class="rounded-2">';
                    })
                    ->addColumn('action', function ($row) {
                           $viewEditButton =   '<a href="'. route('admin.gallery.edit', $row->id) . '" class="btn btn-outline-primary btn-sm btn-inline" title="Modifier le status">
                                                    <i class="fa fa-edit"></i>
                                                </a>';
                            $deleteButtons = '';

                            if (Auth::check() && Auth::user()->isAdmin()) {
                                $deleteButtons = '<a href="javascript:void(0)" type="button" class="btn btn-outline-danger btn-sm btn-inline ms-1" title="Supprimer une image" id="btn-delete-gallery-form-modal" data-id="' . $row->id . '">
                                        <i class="fa fa-trash"></i>
                                    </a>';
                            }

                            return '<div class="d-flex justify-content-center">' . $viewEditButton . $deleteButtons . '</div>';
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
