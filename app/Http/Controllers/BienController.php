<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bien;
use App\Models\Proprietaire;
use Illuminate\Support\Facades\Auth;

class BienController extends Controller
{
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
     * Liste les biens de l'agence connectée.
     */
    public function index()
    {
        $user = Auth::user();
        $biens = Bien::with(['proprietaire', 'reservations', 'contrats'])
            ->where('agence_id', $user->agence_id)
            ->get();

        return view('biens.index', compact('biens'));
    }

    /**
     * Affiche le formulaire de création d'un bien.
     */
    public function create()
    {
        $proprietaires = Proprietaire::where('agence_id', Auth::user()->agence_id)->get();
        return view('biens.create', compact('proprietaires'));
    }

    /**
     * Enregistre un nouveau bien dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'surface' => 'required|numeric',
            'prix' => 'required|numeric',
            'status' => 'required|string|max:50',  
            'description' => 'nullable|string',
            'proprietaire_id' => 'required|exists:proprietaires,id',
        ]);

        $user = Auth::user();
        Bien::create(array_merge($request->all(), ['agence_id' => $user->agence_id]));

        return redirect()->route('biens.index')->with('success', 'Bien ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un bien.
     */
    public function show($id)
    {
        $bien = Bien::with(['proprietaire', 'reservations', 'contrats'])
            ->where('id', $id)
            ->where('agence_id', Auth::user()->agence_id)
            ->firstOrFail();

        return view('biens.show', compact('bien'));
    }

    /**
     * Affiche le formulaire d'édition d'un bien.
     */
    public function edit($id)
    {
        $bien = Bien::where('id', $id)
            ->where('agence_id', Auth::user()->agence_id)
            ->firstOrFail();

        $proprietaires = Proprietaire::where('agence_id', Auth::user()->agence_id)->get();

        return view('biens.edit', compact('bien', 'proprietaires'));
    }

    /**
     * Met à jour un bien existant.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'surface' => 'required|numeric',
            'prix' => 'required|numeric',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'proprietaire_id' => 'required|exists:proprietaires,id',
        ]);

        $bien = Bien::where('id', $id)
            ->where('agence_id', Auth::user()->agence_id)
            ->firstOrFail();

        $bien->update($request->all());

        return redirect()->route('biens.index')->with('success', 'Bien mis à jour avec succès.');
    }

    /**
     * Supprime un bien.
     */
    public function destroy($id)
    {
        $bien = Bien::where('id', $id)
            ->where('agence_id', Auth::user()->agence_id)
            ->firstOrFail();

        $bien->delete();

        return redirect()->route('biens.index')->with('success', 'Bien supprimé avec succès.');
    }

    /**
     * Génère des statistiques pour les biens de l'agence connectée.
     */
    public function statistics()
    {
        $user = Auth::user();
    
        $stats = Bien::where('agence_id', $user->agence_id)
            ->selectRaw('status, nom, type, COUNT(*) as count')
            ->groupBy('status', 'nom', 'type')
            ->orderBy('status')
            ->get();
    
        return view('biens.statistics', compact('stats'));
    }
    
}
