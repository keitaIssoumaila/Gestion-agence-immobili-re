<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    // Afficher la liste des biens
    public function index()
    {
        // Récupérer les biens avec pagination (par exemple, 10 biens par page)
        $biens = Bien::paginate(10);  // Change "10" pour le nombre de biens que tu veux par page
    
        // Retourner la vue avec les biens paginés
        return view('biens.index', compact('biens'));
    }
    // Afficher le formulaire de création d'un bien
    public function create()
    {
        // Récupérer toutes les agences et propriétaires disponibles
        $agences = Agence::all();
        $proprietaires = Proprietaire::all();
    
        // Retourner la vue 'biens.create' avec les données des agences et propriétaires
        return view('biens.create', compact('agences', 'proprietaires'));
    }

    // Stocker un nouveau bien
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'surface'=>'nullable|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'agence_id' => 'required|exists:agences,id',  // Valider l'existence de l'agence
            'proprietaire_id' => 'required|exists:proprietaires,id',  // Valider l'existence du propriétaire
            
        ]);

        Bien::create($request->all());
        return redirect()->route('biens.index')->with('success', 'Bien ajouté avec succès !');
    }

    // Afficher un bien spécifique
    public function show($id)
    {
        $bien = Bien::with(['agence', 'proprietaire'])->findOrFail($id);
        return view('biens.show', compact('bien'));
    }

    // Afficher le formulaire d'édition d'un bien
    public function edit($id)
    {
        $bien = Bien::findOrFail($id);
        return view('biens.edit', compact('bien'));
    }

    // Mettre à jour un bien
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'surface'=>'nullable|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'agence_id' => 'required|exists:agences,id',  // Valider l'existence de l'agence
            'proprietaire_id' => 'required|exists:proprietaires,id',  // Valider l'existence du propriétaire
        ]);

        $bien = Bien::findOrFail($id);
        $bien->update($request->all());
        return redirect()->route('biens.index')->with('success', 'Bien mis à jour avec succès !');
    }

    // Supprimer un bien
    public function destroy($id)
    {
        $bien = Bien::findOrFail($id);
    
        // Vérifier s'il y a des réservations associées au bien
        if ($bien->reservations()->count() > 0) {
            return redirect()->route('biens.index')->with('error', 'Impossible de supprimer ce bien, il est lié à des réservations.');
        }
    
        $bien->delete();
    
        return redirect()->route('biens.index')->with('success', 'Bien supprimé avec succès !');
    }
}
