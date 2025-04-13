<?php

namespace App\Http\Controllers\ADMIN;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UsersController extends Controller
{
    use AuthorizesRequests;

    protected $userServcies;

    public function __construct(UserServices $userServcies)
    {
        $this->userServcies = $userServcies;
    }
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // try {

        //     if ($request->ajax()) {
        //         $utilisateurs = $this->userServcies->getAllUsers(['id','avatar','pseudo','contact','role','status']);
        //         return DataTables::of($utilisateurs)
        //             ->addColumn('action', function ($row) {
        //                 $viewEditButton = '
        //                     <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm btn-inline" id="btn-show-utilisateur-modal" data-id="'.$row->id.'" title="Voir un utilisateur">
        //                         <i class="fa fa-eye"></i>
        //                     </a>
                            
        //                 ';
        //                 // Vérifiez le rôle de l'utilisateur pour afficher les actions supplémentaires
        //                 $deleteButtons = '';
        //                 if (Auth::check() && Auth::user()->role == "admin") {
        //                     $deleteButtons = '
        //                         <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-inline ms-1" title="Modifier un utilisateur" id="btn-update-utilisateur-form-modal" data-id="'.$row->id.'">
        //                             <i class="fa fa-edit"></i>
        //                         </a>
        //                         <a href="javascript:void(0)" type="button" class="btn btn-outline-danger btn-sm btn-inline ms-1" title="Supprimer un utilisateur" id="btn-delete-utilisateur-form-modal" data-id="'.$row->id.'">
        //                             <i class="fa fa-trash"></i>
        //                         </a>';
        //                 }
        //                 return '<div class="d-flex justify-content-center">'.$viewEditButton.$deleteButtons.'</div>';
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        //     }

        //     return view('admin.users.index');
        // } catch (Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }       
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $user = $this->userServcies->getUserById($id);

        // if(!$user){
        //     abort(404);
        // }

        // $imagePath = asset(config('public_path.public_path') . 'images/' . ($user->image ?? 'img.png'));
        
        // return response()->json([
        //     'success' => true,
        //     'user' => $user,
        //     'imagePath' => $imagePath
        // ]);
    }
    
    public function edit(string $id)
    {
        // $user = $this->userServcies->getUserById($id);

        // if(!$user){
        //     abort(404);
        // }
        // return response()->json([
        //     'success' => true,
        //     'user' => $user
        // ]);
    }

    public function approuve(Request $request, string $id)
    {
        // $user = $this->userServcies->getUserById($id);

        // if (!$user) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Utilisateur non trouvée'
        //     ], 404);
        // }
            
        // $data['roles'] = $request->role;
        // $data['status'] = 'active';
        // $user->update($data);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Vous avez approuvé un utilisateur'
        // ]);
    }

    public function update(Request $request, string $id)
    {
        // $user = User::find($id);

        // if (!$user) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Utilisateur non trouvée'
        //     ], 404);
        // }
            
        // $data['role'] = $request->role;
        
        // $user->update($data);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Mise à jour effectuée'
        // ]);
    }

    public function destroy(string $id)
    {
        // $user = $this->userServcies->getUserById($id);
        
        // if (!$user) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Utilisateur non trouvée'
        //     ], 404);
        // }

        // $user->delete();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Utilisateur supprimée avec succès'
        // ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function checkEmail(){
        // if(Auth::check()){
        //     $user = Auth::user();
        //     if($user->email_verified_at === NULL){
        //         return view('auth.verify-email');
        //     }else{
        //         if($user->status === 'inactive'){
        //             return redirect()->route('status.not.approuved');
        //         }else{
        //             return redirect()->route('admin.dashboard');
        //         }
        //     }
        // }else{
        //     return redirect()->route('login');
        // }
    }
}