<?php

namespace App\Http\Controllers;

use App\Models\User; // Assurez-vous que le modèle User est bien importé
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminAgenceController extends Controller
{
    public function editProfile()
{
    $admin = Auth::user(); // Récupère l'utilisateur connecté
    return view('adminagence.edit-profile', compact('admin'));
}


public function updateProfile(Request $request)
{
    $admin = Auth::user(); // Récupère l'utilisateur connecté

    // Validation des champs, y compris le mot de passe actuel
    $request->validate([
        'current_password' => 'required|string', // Mot de passe actuel obligatoire
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
        'password' => 'nullable|string|min:8|confirmed', // Nouveau mot de passe optionnel
    ]);

    // Vérifie que le mot de passe actuel est correct
    if (!Hash::check($request->current_password, $admin->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    // Mise à jour des informations
    $admin->update([
        'name' => $request->name,
        'email' => $request->email,
        // Si un nouveau mot de passe est fourni, on le met à jour
        'password' => $request->password ? Hash::make($request->password) : $admin->password,
    ]);

    return redirect()->route('adminagence.create-user')->with('success', 'Votre profil a été mis à jour avec succès.');
}


    // Affiche le formulaire pour créer un utilisateur
   public function showCreateUserForm()
{
    $adminAgenceId = auth()->user()->agence_id;

    $users = User::where('agence_id', $adminAgenceId)->get();

    return view('adminagence.create-user', compact('users'));
}

    // Enregistre un nouvel utilisateur
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['user', 'manager'])],
        ]);

        // Création de l'utilisateur
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'agence_id' => Auth::user()->agence_id,
            'role' => $request->role,
        ]);

        // Redirection avec un message de succès
        return redirect()->route('adminagence.create-user')->with('success', 'Utilisateur créé avec succès');
    }
    
    
   // Modifie la méthode dans votre contrôleur AdminAgenceController
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Vérifie si l'utilisateur appartient à la même agence
    if (auth()->user()->agence_id !== $user->agence_id) {
        return redirect()->route('adminagence.create-user')->with('error', 'Vous n\'êtes pas autorisé à modifier cet utilisateur.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Permet la mise à jour de l'email
        'role' => ['required', Rule::in(['user', 'manager'])], // Valide les rôles autorisés
    ]);

    // Mise à jour des informations de l'utilisateur
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('adminagence.create-user')->with('success', 'Informations de l\'utilisateur mises à jour avec succès.');
}



public function showUsersList()
{
    $adminAgenceId = auth()->user()->agence_id; // Récupère l'agence de l'administrateur connecté

    if (!$adminAgenceId) {
        return redirect()->back()->withErrors('Agence non définie pour cet utilisateur.');
    }

    $users = User::where('agence_id', $adminAgenceId)->get(); // Filtre les utilisateurs de l'agence

    return view('adminagence.create-user', compact('users'));
}

public function toggleUserStatus($id)
{
    $user = User::findOrFail($id);

    if (auth()->user()->agence_id !== $user->agence_id) {
        return redirect()->route('adminagence.create-user')->with('error', 'Action non autorisée.');
    }

    // Empêcher l'administrateur de désactiver son propre compte
    if (auth()->user()->id === $user->id) {
        return redirect()->route('adminagence.create-user')->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    $status = $user->is_active ? 'activé' : 'désactivé';
    return redirect()->route('adminagence.create-user')->with('success', "Utilisateur $status avec succès.");
}

}
