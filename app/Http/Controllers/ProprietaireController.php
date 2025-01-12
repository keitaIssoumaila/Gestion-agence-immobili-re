<?php

namespace App\Http\Controllers;

use App\Models\Proprietaire;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProprietaireController extends Controller
{
    /**
     * Vérifie si l'utilisateur est actif avant d'accéder à toutes les méthodes du contrôleur.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->is_active) {
                return redirect()->route('login')->with('error', 'Votre compte n\'est pas activé.');
            }
            return $next($request);
        });
    }

    /**
     * Affiche la liste des propriétaires pour l'agence de l'utilisateur connecté.
     */
    public function index()
    {
        $user = Auth::user();
        $proprietaires = Proprietaire::where('agence_id', $user->agence_id)->get();
        return view('proprietaires.index', compact('proprietaires'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau propriétaire.
     */
    public function create()
    {
        return view('proprietaires.create');
    }

    /**
     * Enregistre un nouveau propriétaire dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:proprietaires,email',
            'genre' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'adresse' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        Proprietaire::create(array_merge($request->all(), ['agence_id' => $user->agence_id]));

        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un propriétaire.
     */
    public function show($id)
    {
        $user = Auth::user();
        $proprietaire = Proprietaire::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        return view('proprietaires.show', compact('proprietaire'));
    }

    /**
     * Affiche le formulaire pour modifier un propriétaire.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $proprietaire = Proprietaire::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        return view('proprietaires.edit', compact('proprietaire'));
    }

    /**
     * Met à jour les informations d'un propriétaire.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:proprietaires,email,' . $id,
            'genre' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'adresse' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $proprietaire = Proprietaire::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        $proprietaire->update($request->all());

        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire mis à jour avec succès.');
    }

    /**
     * Supprime un propriétaire de la base de données.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $proprietaire = Proprietaire::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        $proprietaire->delete();

        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire supprimé avec succès.');
    }
}
