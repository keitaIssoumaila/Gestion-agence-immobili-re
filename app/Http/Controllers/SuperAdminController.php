<?php 

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Afficher la liste des administrateurs avec leurs agences.
     */
    public function showAdminsList()
    {
        $admins = User::where('role', 'admin')->with('agence')->get();
        $agences = Agence::all();

        return view('superadmin.admins-list', compact('admins', 'agences'));
    }

    /**
     * Créer un administrateur et l'associer à une agence.
     */
    public function storeAdmin(Request $request)
    {
        // Validation directe dans cette méthode
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agence_id' => 'required|exists:agences,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'agence_id' => $request->agence_id,
            'role' => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('admins-list')->with('success', 'Administrateur créé avec succès.');
    }

    /**
     * Modifier un administrateur.
     */
    public function updateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validation directe dans cette méthode
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'agence_id' => 'required|exists:agences,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'agence_id' => $request->agence_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admins-list')->with('success', 'Administrateur mis à jour avec succès.');
    }

      /**
     * Récupérer les statistiques globales.
     * Renvoie le nombre total d'agences, d'utilisateurs et d'administrateurs.
     */
    public function getStatistics()
    {
        $agenciesCount = Agence::count();
        $adminsCount = User::where('role', 'admin')->count();
    
        return response()->json([
            'agencies' => $agenciesCount,
            'admins' => $adminsCount,
        ]);
    }
    

   // Méthode pour basculer l'activation d'un administrateur
   public function toggleUserStatus($id)
   {
       // Vérification des permissions de l'utilisateur
       if (Auth::user()->role !== 'super_admin') {
           return redirect()->route('home')->with('error', 'Vous n\'avez pas l\'autorisation d\'effectuer cette action.');
       }

       // Trouver l'administrateur par son ID
       $admin = User::findOrFail($id);

       // Sauvegarder l'état précédent de l'activation
       $wasActive = $admin->is_active;

       // Inverser l'état actif
       $admin->is_active = !$admin->is_active;
       $admin->save();

       // Si l'utilisateur était actif et qu'il est maintenant désactivé, le déconnecter
       if (!$admin->is_active && $wasActive) {
           // Révoquer tous les tokens actifs (si Laravel Sanctum est utilisé)
           $admin->tokens()->delete();  // Nécessite Laravel Sanctum si utilisé
       }

       // Déterminer le message de succès
       $status = $admin->is_active ? 'activé' : 'désactivé';

       // Retourner à la liste des administrateurs avec un message de succès
       return redirect()->route('admins-list')->with('success', "L'administrateur a été $status avec succès.");
   }


   public function toggleAgencyStatus($id)
    {
        // Vérification des permissions de l'utilisateur
        if (Auth::user()->role !== 'super_admin') {
            return response()->json(['error' => 'Vous n\'avez pas l\'autorisation d\'effectuer cette action.'], 403);
        }
    
        try {
            // Trouver l'agence par son ID
            $agence = Agence::findOrFail($id);
    
            // Vérifier si l'agence est déjà active ou non
            $wasActive = $agence->is_active;
    
            // Si l'agence est actuellement inactive, on l'active
            if (!$wasActive) {
                // Activation de l'agence
                $agence->is_active = true;
                $agence->save();
    
                // Activer tous les utilisateurs de cette agence
                $agence->users()->update(['is_active' => true]);
    
                return response()->json([
                    'status' => 'success',
                    'is_active' => true,
                    'message' => 'L\'agence a été activée avec succès.'
                ]);
            }
    
            // Si l'agence est active, on la désactive
            if ($wasActive) {
                // Désactivation de l'agence
                $agence->is_active = false;
                $agence->save();
    
                // Désactiver tous les utilisateurs de cette agence
                $agence->users()->update(['is_active' => false]);
    
                return response()->json([
                    'status' => 'success',
                    'is_active' => false,
                    'message' => 'L\'agence a été désactivée avec succès.'
                ]);
            }
    
        } catch (\Exception $e) {
            // Log l'exception pour faciliter le debug
            \Log::error('Erreur lors de la mise à jour de l\'agence: ' . $e->getMessage());
    
            return response()->json(['error' => 'Une erreur est survenue. Veuillez réessayer.'], 500);
        }
    }

}
