<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    /**
     * Vérifie si l'utilisateur est actif avant d'accéder à toutes les méthodes du contrôleur.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_active) {
                return redirect()->route('home')->with('error', 'Votre compte est inactif. Veuillez contacter l\'administrateur.');
            }
            return $next($request);
        });
    }

    /**
     * Affiche la liste des paiements pour l'agence de l'utilisateur connecté.
     */
    public function index()
    {
        $paiements = Paiement::where('agence_id', Auth::user()->agence_id)->get();
        return view('paiements.index', compact('paiements'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau paiement.
     */
    public function create()
    {
        $contrats = Contrat::where('agence_id', Auth::user()->agence_id)->get();
        return view('paiements.create', compact('contrats'));
    }

    /**
     * Enregistre un nouveau paiement dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'status' => 'required|string',
            'contrat_id' => 'nullable|exists:contrats,id',
        ]);

        Paiement::create([
            'montant' => $request->montant,
            'date_paiement' => $request->date_paiement,
            'status' => $request->status,
            'contrat_id' => $request->contrat_id,
            'agence_id' => Auth::user()->agence_id,
        ]);

        return redirect()->route('paiements.index')->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un paiement.
     */
    public function show(Paiement $paiement)
    {
        $this->authorizeAccess($paiement);

        return view('paiements.show', compact('paiement'));
    }

    /**
     * Affiche le formulaire pour modifier un paiement.
     */
    public function edit(Paiement $paiement)
    {
        $this->authorizeAccess($paiement);

        $contrats = Contrat::where('agence_id', Auth::user()->agence_id)->get();
        return view('paiements.edit', compact('paiement', 'contrats'));
    }

    /**
     * Met à jour les informations d'un paiement.
     */
    public function update(Request $request, Paiement $paiement)
    {
        $this->authorizeAccess($paiement);

        $request->validate([
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'status' => 'required|string',
            'contrat_id' => 'nullable|exists:contrats,id',
        ]);

        $paiement->update([
            'montant' => $request->montant,
            'date_paiement' => $request->date_paiement,
            'status' => $request->status,
            'contrat_id' => $request->contrat_id,
        ]);

        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Supprime un paiement de la base de données.
     */
    public function destroy(Paiement $paiement)
    {
        $this->authorizeAccess($paiement);

        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }

    /**
     * Génère un reçu pour un paiement spécifique.
     */
    public function printReceipt(Paiement $paiement)
    {
        $this->authorizeAccess($paiement);

        $contrat = $paiement->contrat;
        $agence = Auth::user()->agence;

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('paiements.receipt', compact('paiement', 'contrat', 'agence'));
        return $pdf->stream('reçu_paiement_' . $paiement->id . '.pdf');
    }

    /**
     * Autorise l'accès uniquement aux paiements appartenant à l'agence de l'utilisateur connecté.
     */
    private function authorizeAccess(Paiement $paiement)
    {
        if ($paiement->agence_id !== Auth::user()->agence_id) {
            abort(403, 'Accès non autorisé.');
        }
    }
}
