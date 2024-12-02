<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\BienModel;
use App\Models\LocataireModel;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Afficher la liste des réservations
    public function index()
    {
        $reservations = Reservation::with('bien', 'locataire')->get();
        return view('reservations.index', compact('reservations'));
    }

    // Afficher le formulaire de création d'une réservation
    public function create()
    {
        $biens = BienModel::all(); // Tous les biens disponibles
        $locataires = LocataireModel::all(); // Tous les locataires
        return view('reservations.create', compact('biens', 'locataires'));
    }

    // Stocker une réservation
    public function store(Request $request)
    {
        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',  // Validation du locataire
            'bien_id' => 'required|exists:biens,id',  // Validation du bien
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        Reservation::create($request->all());

        return redirect()->route('reservations.index')->with('success', 'Réservation ajoutée avec succès !');
    }

    // Afficher une réservation spécifique
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    // Afficher le formulaire d'édition d'une réservation
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $biens = BienModel::all(); // Récupérer tous les biens
        $locataires = LocataireModel::all(); // Récupérer tous les locataires
        return view('reservations.edit', compact('reservation', 'biens', 'locataires'));
    }

    // Mettre à jour une réservation existante
    public function update(Request $request, $id)
    {
        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Réservation mise à jour avec succès !');
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Réservation supprimée avec succès !');
    }
}
