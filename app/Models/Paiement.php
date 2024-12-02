<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'paiements';

    // Colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'montant', 'date_paiement', 'status', 'contrat_id', 'agence_id'
    ];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }
    // Un paiement appartient à un contrat
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}
