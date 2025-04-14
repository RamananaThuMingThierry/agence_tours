<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('backoffice.profile.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'pseudo' => 'required|string|max:255',
            'contact' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->pseudo = $request->pseudo;
        $user->contact = $request->contact;
        $user->address = $request->address;

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images/users'), $filename);
            $user->avatar = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }

}
