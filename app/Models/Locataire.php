<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locataire extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'locataires';

    // Colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'adresse', 'agence_id'
    ];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // Un locataire peut avoir plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    // Un locataire peut faire plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
