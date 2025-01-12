<?php
namespace App\Http\Controllers;

use App\Models\Locataire;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocataireController extends Controller
{
    public function __construct()
    {
        // Vérifier si l'utilisateur est authentifié et actif
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->is_active) {
                return redirect()->route('login')->withErrors('Votre compte est inactif.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        // Vérifier que l'utilisateur appartient à l'agence de ses locataires
        $locataires = Locataire::where('agence_id', Auth::user()->agence_id)->get();
        return view('locataires.index', compact('locataires'));
    }

    public function create()
    {
        // Vérifier que l'utilisateur appartient à une agence
        if (Auth::user()->agence_id) {
            return view('locataires.create');
        }

        return redirect()->route('locataires.index')->withErrors('Vous devez être associé à une agence pour ajouter un locataire.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:locataires,email',
            'genre' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
        ]);

        // Créer un nouveau locataire
        $locataire = new Locataire($request->all());
        $locataire->agence_id = Auth::user()->agence_id;
        $locataire->save();

        return redirect()->route('locataires.index')->with('success', 'Locataire ajouté avec succès.');
    }

    public function show($id)
    {
        $locataire = Locataire::where('agence_id', Auth::user()->agence_id)->findOrFail($id);
        return view('locataires.show', compact('locataire'));
    }

    public function edit($id)
    {
        $locataire = Locataire::where('agence_id', Auth::user()->agence_id)->findOrFail($id);
        return view('locataires.edit', compact('locataire'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:locataires,email,' . $id,
            'genre' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
        ]);

        $locataire = Locataire::where('agence_id', Auth::user()->agence_id)->findOrFail($id);
        $locataire->update($request->all());

        return redirect()->route('locataires.index')->with('success', 'Locataire mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $locataire = Locataire::where('agence_id', Auth::user()->agence_id)->findOrFail($id);
        $locataire->delete();

        return redirect()->route('locataires.index')->with('success', 'Locataire supprimé avec succès.');
    }
}
