<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'reservations';

    // Colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'locataire_id', 'agence_id', 'bien_id', 'date_reservation', 'status'
    ];

    // Une réservation appartient à un locataire
    public function locataire()
    {
        return $this->belongsTo(Locataire::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // Une réservation est pour un bien
    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
