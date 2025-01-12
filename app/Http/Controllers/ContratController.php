<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Bien;
use App\Models\Locataire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContratController extends Controller
{
    /**
     * Liste des contrats pour une agence.
     */
    public function index()
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est actif
        if (!$user->is_active) {
            return redirect()->route('home')->with('error', 'Votre compte est désactivé.');
        }

        // Récupérer les contrats de l'agence
        $contrats = Contrat::where('agence_id', $user->agence_id)->get();

        return view('contrats.index', compact('contrats'));
    }

    /**
     * Afficher le formulaire de création d'un contrat.
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user->is_active) {
            return redirect()->route('home')->with('error', 'Votre compte est désactivé.');
        }

        // Récupérer les biens et locataires pour l'agence
        $biens = Bien::where('agence_id', $user->agence_id)->get();
        $locataires = Locataire::where('agence_id', $user->agence_id)->get();

        return view('contrats.create', compact('biens', 'locataires'));
    }

    /**
     * Enregistrer un nouveau contrat.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->is_active) {
            return redirect()->route('home')->with('error', 'Votre compte est désactivé.');
        }

        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'montant' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
        ]);

        Contrat::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'montant' => $request->montant,
            'description' => $request->description,
            'locataire_id' => $request->locataire_id,
            'bien_id' => $request->bien_id,
            'agence_id' => $user->agence_id,
        ]);

        return redirect()->route('contrats.index')->with('success', 'Contrat créé avec succès.');
    }

    /**
     * Afficher les détails d'un contrat.
     */
    public function show(Contrat $contrat)
    {
        $user = Auth::user();

        if (!$user->is_active || $contrat->agence_id !== $user->agence_id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('contrats.show', compact('contrat'));
    }

    /**
     * Afficher le formulaire d'édition d'un contrat.
     */
    public function edit(Contrat $contrat)
    {
        $user = Auth::user();

        if (!$user->is_active || $contrat->agence_id !== $user->agence_id) {
            abort(403, 'Accès non autorisé.');
        }

        $biens = Bien::where('agence_id', $user->agence_id)->get();
        $locataires = Locataire::where('agence_id', $user->agence_id)->get();

        return view('contrats.edit', compact('contrat', 'biens', 'locataires'));
    }

    /**
     * Mettre à jour un contrat existant.
     */
    public function update(Request $request, Contrat $contrat)
    {
        $user = Auth::user();

        if (!$user->is_active || $contrat->agence_id !== $user->agence_id) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'montant' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
        ]);

        $contrat->update($request->all());

        return redirect()->route('contrats.index')->with('success', 'Contrat mis à jour avec succès.');
    }

    /**
     * Supprimer un contrat.
     */
    public function destroy(Contrat $contrat)
    {
        $user = Auth::user();

        if (!$user->is_active || $contrat->agence_id !== $user->agence_id) {
            abort(403, 'Accès non autorisé.');
        }

        $contrat->delete();

        return redirect()->route('contrats.index')->with('success', 'Contrat supprimé avec succès.');
    }
}
