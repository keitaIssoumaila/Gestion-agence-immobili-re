<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    // Méthodes privées pour éviter les redondances

    /**
     * Récupérer toutes les agences.
     */
    private function getAgences()
    {
        return Agence::all();
    }

    /**
     * Récupérer les utilisateurs d'une agence spécifique (par défaut, exclut le super administrateur).
     */
    private function getUsersByAgence($roles = [])
    {
        // Filtrer les utilisateurs en excluant les super admins
        $query = User::where('role', '!=', 'super_admin');
    
        // Si l'utilisateur connecté appartient à une agence, filtrer par agence
        if (!empty(Auth::user()->agence_id)) {
            $query->where('agence_id', Auth::user()->agence_id);
        }
    
        // Appliquer les filtres de rôle si spécifiés
        if (!empty($roles)) {
            $query->whereIn('role', $roles);
        }
    
        return $query->get();
    }
    
    /**
     * Valider les données de création ou mise à jour d'utilisateur.
     */
    private function validateUserRequest(Request $request, $isAdmin = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . ($request->id ?? 'NULL'),
            'password' => 'nullable|string|min:8|confirmed',
        ];

        if ($isAdmin) {
            $rules['agence_id'] = 'required|exists:agences,id';
        } else {
            $rules['role'] = ['required', Rule::in(['user', 'manager'])];
        }

        $request->validate($rules);
    }

    // Gestion des administrateurs

    public function showAdminsList()
    {
        $users = User::all();
        $admins = User::where('role', 'admin')->with('agence')->get();
        $agences = $this->getAgences();

        return view('superadmin.admins-list', compact('users', 'admins', 'agences'));
    }

    public function storeAdmin(Request $request)
    {
        $this->validateUserRequest($request, true);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'agence_id' => $request->agence_id,
            'role' => 'admin',
        ]);

        return redirect()->route('superadmin.admins-list')->with('success', 'Administrateur créé avec succès.');
    }

    public function editUserOrAdmin(Request $request, $id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id);
    
        // Vérification du rôle de l'utilisateur (admin ou utilisateur)
        if ($user->role == 'admin') {
            // Validation spécifique pour les administrateurs (si l'utilisateur est un admin)
            $this->validateUserRequest($request, true);  
        } else {
            // Validation pour les utilisateurs (si l'utilisateur n'est pas un admin)
            $this->validateUserRequest($request);  
        }
    
        // Mise à jour des données communes : nom, email, et agence
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'agence_id' => $request->agence_id ?? $user->agence_id,  // Garder l'agence actuelle si non spécifié
        ]);
    
        // Mise à jour du mot de passe si rempli
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
    
        // Mise à jour du rôle si nécessaire (uniquement pour les utilisateurs qui ne sont pas administrateurs)
        if ($user->role != 'admin' && $request->role) {
            $user->update(['role' => $request->role]);
        }
    
        // Redirection avec message de succès
        return redirect()->route('superadmin.users-list')->with('success', 'Utilisateur ou administrateur mis à jour avec succès.');
    }
    
    // Gestion des utilisateurs  

    public function showUsersList(Request $request)
    {
        // Charger uniquement les utilisateurs avec le rôle 'user'
        $users = User::with('agence')
                     ->where('role', 'user')
                     ->get(); // Récupérer tous les utilisateurs sans pagination
     
        $agences = $this->getAgences(); // Récupérer les agences si nécessaire
     
        return view('superadmin.users-list', compact('users', 'agences'));
    }
    

    public function storeUser(Request $request)
    {
        $this->validateUserRequest($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'agence_id' => Auth::user()->agence_id,
            'role' => $request->role,
        ]);

        return redirect()->route('superadmin.admins-list')->with('success', 'Utilisateur créé avec succès.');
    }

    public function toggleUserActivation($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('status');
        }

        return back()->with('status', 'L\'état de l\'utilisateur a été mis à jour.');
    }
    
    
     public function getStatistics()
{
    $agenciesCount = Agence::count(); 
    $usersCount = User::count();
    $adminsCount = User::where('role', 'admin')->count();

    return response()->json([ 
        'agencies' => $agenciesCount,
        'users' => $usersCount,
        'admins' => $adminsCount,
    ]);
}

 
}
