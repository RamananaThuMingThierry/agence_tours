<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Services\TourImageServices;
use App\Http\Controllers\Controller;

class TourImagesController extends Controller
{
    private $tourImageService;

    public function __construct(TourImageServices $tourImageService)
    {
        $this->tourImageService = $tourImageService;
    }

    public function destroy(string $encrypt_id)
    {
        try {
            $id = Crypt::decryptString($encrypt_id);

            $tourImage = $this->tourImageService->getTourImageById($id);

            if (!$tourImage) {
                return response()->json([
                    'status' => 404,
                    'message' => __('tour.image_not_found')
                ], 404);
            }

            // Vérifier si l'image est la seule de l'élément
            $imageCount = Gallery::where('tour_id', $tourImage->tour_id)
                ->count();

            if ($imageCount <= 1) {
                return response()->json([
                    'status' => 422,
                    'message' => __('tour.image_delete_error')
                ], 422);
            }

            // Construire le chemin physique
            $imagePath = public_path("images/tours/" . $tourImage->image);

            // Supprimer le fichier physique si présent
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Supprimer l'image de la base de données
            $this->tourImageService->deleteTourImage($id);

            return response()->json([
                'status' => 200,
                'message' => __('tour.image_delete_success')
            ]);
        } catch (DecryptException $e) {
            return response()->json([
                'status' => 400,
                'message' => __('tour.invalid_image_id')
            ], 400);
        }
    }
}
