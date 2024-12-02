<?php

namespace App\Http\Controllers;

use App\Models\Proprietaire;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
{
    // Afficher la liste des propriétaires
    public function index()
    {
        $proprietaires = Proprietaire::all();
        return view('proprietaires.index', compact('proprietaires'));
    }

    // Afficher le formulaire de création d'un propriétaire
    public function create()
    {
        return view('proprietaires.create');
    }

    // Enregistrer un nouveau propriétaire dans la base de données
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:proprietaires,email',
            'telephone' => 'required|string|max:15',
            'adresse' => 'required|string|max:255',
        ]);

        // Créer un propriétaire
        Proprietaire::create($request->all());

        // Rediriger avec un message de succès
        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire ajouté avec succès.');
    }

    // Afficher un propriétaire spécifique (et ses biens)
    public function show($id)
{
    // Récupérer le propriétaire avec ses biens
    $proprietaire = Proprietaire::with('biens')->findOrFail($id);
    
    // Grouper les biens par type et compter leur nombre
    $biensParType = $proprietaire->biens->groupBy('type')->map(function($biens) {
        return $biens->count();
    });
    
    // Passer ces informations à la vue
    return view('proprietaires.show', compact('proprietaire', 'biensParType'));
}

    // Afficher le formulaire d'édition d'un propriétaire
    public function edit($id)
    {
        $proprietaire = Proprietaire::findOrFail($id);
        return view('proprietaires.edit', compact('proprietaire'));
    }

    // Mettre à jour un propriétaire
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:proprietaires,email,' . $id,
            'telephone' => 'required|string|max:15',
            'adresse' => 'required|string|max:255',
        ]);

        // Trouver le propriétaire et mettre à jour ses informations
        $proprietaire = Proprietaire::findOrFail($id);
        $proprietaire->update($request->all());

        // Rediriger avec un message de succès
        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire mis à jour avec succès.');
    }

    // Supprimer un propriétaire
    public function destroy($id)
    {
        $proprietaire = Proprietaire::findOrFail($id);
        $proprietaire->delete();

        return redirect()->route('proprietaires.index')->with('success', 'Propriétaire supprimé avec succès.');
    }
}
