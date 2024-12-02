<?php

namespace App\Http\Controllers;

use App\Models\Locataire;
use Illuminate\Http\Request;

class LocataireController extends Controller
{
    // Afficher la liste des locataires
    public function index()
    {
        $locataires = Locataire::all();
        return view('locataires.index', compact('locataires'));
    }

    // Afficher le formulaire de création d'un locataire
    public function create()
    {
        return view('locataires.create');
    }

    // Stocker un nouveau locataire
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:locataires,email',
            'telephone' => 'required|string|max:15',
        ]);

        Locataire::create($request->all());
        return redirect()->route('locataires.index')->with('success', 'Locataire ajouté avec succès !');
    }

    // Afficher un locataire spécifique
    public function show($id)
    {
        $locataire = Locataire::findOrFail($id);
        return view('locataires.show', compact('locataire'));
    }

    // Afficher le formulaire d'édition d'un locataire
    public function edit($id)
    {
        $locataire = Locataire::findOrFail($id);
        return view('locataires.edit', compact('locataire'));
    }

    // Mettre à jour un locataire
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:locataires,email,' . $id,
            'telephone' => 'required|string|max:15',
        ]);

        $locataire = Locataire::findOrFail($id);
        $locataire->update($request->all());
        return redirect()->route('locataires.index')->with('success', 'Locataire mis à jour avec succès !');
    }

    // Supprimer un locataire
    public function destroy($id)
    {
        $locataire = Locataire::findOrFail($id);
        $locataire->delete();
        return redirect()->route('locataires.index')->with('success', 'Locataire supprimé avec succès !');
    }
}
