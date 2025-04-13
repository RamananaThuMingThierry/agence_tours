<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use Illuminate\Http\Request;
use App\Services\GallerieServices;
use App\Http\Controllers\Controller;
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
                        return '<img src="' . asset($row->image_url) . '" alt="Image" width="100">';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('admin.gallery.edit', $row->id) . '" class="btn btn-sm btn-primary">Modifier</a>';
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
