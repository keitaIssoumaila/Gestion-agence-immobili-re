<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;  // Import correct de la classe Request
use Illuminate\Support\Facades\Auth; // N'oubliez pas d'importer aussi la façade Auth

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo() 
    {
        $user = Auth::user();

        // Redirection en fonction du rôle
        if ($user->role === 'super_admin') {
            return '/admin-dashboard'; // Page du super administrateur
        } elseif ($user->role === 'admin') {
            return '/admin-agence'; // Page pour les administrateurs d'agence
        }

        return '/home'; // Page par défaut
    }  

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        // Validation des données de connexion
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Tenter de s'authentifier
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Vérifier si l'utilisateur est actif
            $user = Auth::user();

            // Si l'utilisateur est désactivé, déconnectez-le et renvoyez un message d'erreur
            if (!$user->is_active) {
                Auth::logout(); // Déconnecte l'utilisateur
                return redirect()->route('login')->with('error', 'Votre compte a été désactivé.');
            }

            // Ajouter un message de succès dans la session
            session()->flash('success', 'Connexion réussie ! Bienvenue, ' . $user->name . '.');

            // Si l'utilisateur est actif, redirigez-le vers la page d'accueil ou dashboard
            return redirect()->route('home');
        }

        // Si l'authentification échoue
        return redirect()->route('login')->with('error', 'Identifiants invalides');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();  // Déconnecte l'utilisateur
        $request->session()->invalidate();  // Efface la session
        $request->session()->regenerateToken();  // Génère un nouveau token CSRF

        return redirect('/login');  // Redirige vers la page de connexion
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
