<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Contrat;  // Utilisation du modèle Contrat pour la relation
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    // Afficher la liste des paiements
    public function index()
    {
        // Récupérer tous les paiements avec leurs contrats associés
        $paiements = Paiement::with('contrat')->get();
        return view('paiements.index', compact('paiements'));
    }

    // Afficher le formulaire de création d'un paiement
    public function create()
    {
        // Récupérer tous les contrats pour lier un paiement à un contrat spécifique
        $contrats = Contrat::all();  // Tous les contrats
        return view('paiements.create', compact('contrats'));
    }

    // Stocker un paiement dans la base de données
    public function store(Request $request)
    {
        // Validation des données envoyées par le formulaire
        $request->validate([
            'montant' => 'required|numeric',           // Montant du paiement
            'date_paiement' => 'required|date',        // Date du paiement
            'status' => 'required|string|max:255',     // Statut du paiement (ex: effectué, en attente, etc.)
            'contrat_id' => 'required|exists:contrats,id', // Lien avec le contrat existant
        ]);

        // Création du paiement avec les données validées
        Paiement::create([
            'montant' => $request->montant,
            'date_paiement' => $request->date_paiement,
            'status' => $request->status,
            'contrat_id' => $request->contrat_id,
        ]);

        // Rediriger vers la liste des paiements avec un message de succès
        return redirect()->route('paiements.index')->with('success', 'Paiement ajouté avec succès !');
    }

    // Afficher un paiement spécifique
    public function show($id)
    {
        // Récupérer le paiement et ses informations liées au contrat
        $paiement = Paiement::with('contrat')->findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

    // Afficher le formulaire d'édition d'un paiement
    public function edit($id)
    {
        // Récupérer le paiement existant et tous les contrats pour modification
        $paiement = Paiement::findOrFail($id);
        $contrats = Contrat::all();  // Récupérer tous les contrats
        return view('paiements.edit', compact('paiement', 'contrats'));
    }

    // Mettre à jour un paiement existant
    public function update(Request $request, $id)
    {
        // Validation des données envoyées par le formulaire
        $request->validate([
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'status' => 'required|string|max:255',
            'contrat_id' => 'required|exists:contrats,id', // Lien avec le contrat existant
        ]);

        // Récupérer le paiement existant
        $paiement = Paiement::findOrFail($id);

        // Mettre à jour le paiement avec les nouvelles données
        $paiement->update([
            'montant' => $request->montant,
            'date_paiement' => $request->date_paiement,
            'status' => $request->status,
            'contrat_id' => $request->contrat_id,
        ]);

        // Rediriger vers la liste des paiements avec un message de succès
        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès !');
    }

    // Supprimer un paiement
    public function destroy($id)
    {
        // Récupérer le paiement à supprimer
        $paiement = Paiement::findOrFail($id);

        // Supprimer le paiement
        $paiement->delete();

        // Rediriger vers la liste des paiements avec un message de succès
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès !');
    }
}
