<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'biens';

    // Colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'nom', 'type', 'adresse', 'surface', 'prix', 'status', 'description',  'agence_id', 'proprietaire_id'
    ];

    // Un bien appartient à une seule agence
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // Un bien peut être réservé par plusieurs locataires (via la table de réservation)
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    // Un bien peut avoir plusieurs contrats associés
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }
}
