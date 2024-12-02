<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'contrats';

    // Colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'date_debut', 'date_fin', 'montant', 'description', 'locataire_id', 'bien_id', 'agence_id'
    ];

    // Un contrat appartient à un locataire
    public function locataire()
    { 
        return $this->belongsTo(Locataire::class);
    }

    // Un contrat est pour un bien
    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    // Un contrat est géré par une agence
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // Un contrat peut avoir plusieurs paiements
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
