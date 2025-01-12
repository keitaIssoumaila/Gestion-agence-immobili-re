<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Locataire;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
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
     * Affiche la liste des réservations pour l'agence de l'utilisateur connecté.
     */
    public function index()
    {
        $user = Auth::user();
        $reservations = Reservation::with(['locataire', 'bien'])
            ->where('agence_id', $user->agence_id)
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle réservation.
     */
    public function create()
    {
        $user = Auth::user();
        $locataires = Locataire::where('agence_id', $user->agence_id)->get();
        $biens = Bien::where('agence_id', $user->agence_id)->get();

        return view('reservations.create', compact('locataires', 'biens'));
    }

    /**
     * Enregistre une nouvelle réservation dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
            'date_reservation' => 'required|date',
            'status' => 'required|string|max:50',
        ]);

        $user = Auth::user();
        Reservation::create(array_merge($request->all(), ['agence_id' => $user->agence_id]));

        return redirect()->route('reservations.index')->with('success', 'Réservation ajoutée avec succès.');
    }

    /**
     * Affiche les détails d'une réservation.
     */
    public function show($id)
    {
        $user = Auth::user();
        $reservation = Reservation::with(['locataire', 'bien'])
            ->where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Affiche le formulaire pour modifier une réservation.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $reservation = Reservation::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        $locataires = Locataire::where('agence_id', $user->agence_id)->get();
        $biens = Bien::where('agence_id', $user->agence_id)->get();

        return view('reservations.edit', compact('reservation', 'locataires', 'biens'));
    }

    /**
     * Met à jour une réservation existante.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'locataire_id' => 'required|exists:locataires,id',
            'bien_id' => 'required|exists:biens,id',
            'date_reservation' => 'required|date',
            'status' => 'required|string|max:50',
        ]);

        $user = Auth::user();
        $reservation = Reservation::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Supprime une réservation de la base de données.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $reservation = Reservation::where('id', $id)
            ->where('agence_id', $user->agence_id)
            ->firstOrFail();

        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Réservation supprimée avec succès.');
    }
}
