<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImpersonationController extends Controller
{
    // Méthode pour démarrer l'impersonation
    public function impersonate($userId)
    {
        $user = User::findOrFail($userId);

        // Vérifie si l'utilisateur connecté est un super administrateur
        if (auth()->user()->role !== 'super_admin') {
            abort(403); // Non autorisé
        }

        // Sauvegarder l'ID actuel de l'utilisateur dans la session
        session(['impersonate_id' => auth()->id()]);

        // Connectez-vous en tant qu'utilisateur impersonné
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Vous êtes connecté en tant que ' . $user->name);
    }

    // Méthode pour arrêter l'impersonation et revenir au super administrateur
    public function stopImpersonation()
    {
        $originalId = session('impersonate_id');
        
        if ($originalId) {
            Auth::loginUsingId($originalId);
            session()->forget('impersonate_id');
        }

        return redirect()->route('dashboard')->with('success', 'Retour à votre compte d\'origine');
    }
}
