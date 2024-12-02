<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Locataire;
use App\Models\Bien;
use App\Models\Agence;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    // Afficher la liste des contrats
    public function index()
    {
        $contrats = Contrat::with(['locataire', 'bien', 'agence'])->get();
        return view('contrats.index', compact('contrats'));
    }

    // Afficher le formulaire de création d'un contrat
    public function create()
    {
        $locataires = Locataire::all();
        $biens = Bien::all();
        $agences = Agence::all();
        return view('contrats.create', compact('locataires', 'biens', 'agences'));
    }

    // Stocker un nouveau contrat
    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
            'description'=> 'required|longText',
            'montant' => 'required|numeric',
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
            'agence_id' => 'required|exists:agences,id',
        ]);

        Contrat::create($request->all());
        return redirect()->route('contrats.index')->with('success', 'Contrat créé avec succès !');
    }

    // Afficher un contrat spécifique
    public function show($id)
    {
        $contrat = Contrat::with(['locataire', 'bien', 'agence'])->findOrFail($id);
        return view('contrats.show', compact('contrat'));
    }

    // Afficher le formulaire d'édition d'un contrat
    public function edit($id)
    {
        $contrat = Contrat::findOrFail($id);
        $locataires = Locataire::all();
        $biens = Bien::all();
        $agences = Agence::all();
        return view('contrats.edit', compact('contrat', 'locataires', 'biens', 'agences'));
    }

    // Mettre à jour un contrat
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
            'montant' => 'required|numeric',
            'description'=>'required|longText',
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
            'agence_id' => 'required|exists:agences,id',
        ]);

        $contrat = Contrat::findOrFail($id);
        $contrat->update($request->all());
        return redirect()->route('contrats.index')->with('success', 'Contrat mis à jour avec succès !');
    }

    // Supprimer un contrat
    public function destroy($id)
    {
        // Trouver le contrat par son ID
        $contrat = Contrat::findOrFail($id);
    
        // Vérifier si le contrat est lié à un locataire
        if ($contrat->locataire) {
            return redirect()->route('contrats.index')->with('error', 'Ce contrat est encore lié à un locataire et ne peut pas être supprimé.');
        }
    
        // Vérifier s'il existe des paiements associés au contrat
        if ($contrat->paiements()->count() > 0) {
            return redirect()->route('contrats.index')->with('error', 'Ce contrat est associé à des paiements et ne peut pas être supprimé.');
        }
    
        // Vérifier si le contrat est lié à un bien et si ce bien est toujours loué ou réservé
        if ($contrat->bien && $contrat->bien->status == 'loué' || $bien->status == 'réservé') {
            return redirect()->route('contrats.index')->with('error', 'Le bien associé à ce contrat est toujours ' . $bien->status . ' et le contrat ne peut pas être supprimé.');
        }
    
        // Si toutes les vérifications sont passées, procéder à la suppression du contrat
        $contrat->delete();
    
        return redirect()->route('contrats.index')->with('success', 'Contrat supprimé avec succès !');
    } 


    public function terminerContrat($id)
{
    $contrat = Contrat::findOrFail($id);

    // Si le contrat est terminé, mettre à jour le statut du bien
    if ($contrat->date_fin <= now()) {
        $bien = $contrat->bien;
        $bien->update(['status' => 'disponible']);
    }

    return redirect()->route('contrats.index')->with('success', 'Contrat terminé et bien marqué comme disponible.');
}
   
}
