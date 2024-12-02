<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgenceController extends Controller
{
    // Afficher la liste des agences
    public function index()
    {
        $agences = Agence::all();
        return view('agences.index', compact('agences'));
    }

    // Afficher le formulaire de création d'une agence
    public function create()
    {
        return view('agences.create');
    }

    // Stocker une nouvelle agence
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:agences,email',
            'telephone' => 'nullable|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validation pour l'image
        ]);

        // Si un logo est téléchargé
        if ($request->hasFile('logo')) {
            // Sauvegarder le fichier dans le répertoire 'logos' sous 'public'
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            $logoPath = null;  // Aucun logo, mettre à NULL
        }

        // Créer l'agence avec le logo
        Agence::create([
            'nom' => $request->input('nom'),
            'adresse' => $request->input('adresse'),
            'email' => $request->input('email'), // Ajouter l'email
            'telephone' => $request->input('telephone'),
            'logo' => $logoPath,  // Enregistrer le chemin du logo
        ]);

        return redirect()->route('agences.index')->with('success', 'Agence ajoutée avec succès !');
    }

    // Afficher une agence spécifique
    public function show($id)
    {
        $agence = Agence::findOrFail($id);
        return view('agences.show', compact('agence'));
    }

    // Afficher le formulaire d'édition d'une agence
    public function edit($id)
    {
        $agence = Agence::findOrFail($id);
        return view('agences.edit', compact('agence'));
    }

    // Mettre à jour une agence
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:agences,email',
            'telephone' => 'nullable|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validation du logo
        ]);

        $agence = Agence::findOrFail($id);

        // Si un nouveau logo est téléchargé
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($agence->logo) {
                Storage::disk('public')->delete($agence->logo);
            }

            // Sauvegarder le nouveau logo
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            $logoPath = $agence->logo;  // Ne pas changer le logo s'il n'y a pas de nouveau fichier
        }

        // Mettre à jour l'agence
        $agence->update([
            'nom' => $request->input('nom'),
            'adresse' => $request->input('adresse'),
            'email' => $request->input('email'), // Ajouter l'email
            'telephone' => $request->input('telephone'),
            'logo' => $logoPath,  // Mettre à jour le chemin du logo
        ]);

        return redirect()->route('agences.index')->with('success', 'Agence mise à jour avec succès !');
    }

    // Supprimer une agence
    public function destroy($id)
    {
        $agence = Agence::findOrFail($id);

        // Si un logo existe, le supprimer du stockage
        if ($agence->logo) {
            Storage::disk('public')->delete($agence->logo);
        }

        $agence->delete();
        return redirect()->route('agences.index')->with('success', 'Agence supprimée avec succès !');
    }
}