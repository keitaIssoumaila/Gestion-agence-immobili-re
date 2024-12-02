<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    // Table associée à ce modèle
    protected $table = 'agences';

    // Colonnes qui peuvent être assignées en masse
    protected $fillable = [
        'nom', 'adresse', 'email', 'telephone', 'site_web', 'logo'
    ];

    // Une agence peut avoir plusieurs biens immobiliers
    public function biens()
    {
        return $this->hasMany(Bien::class);
    }

    public function proprietaires()
    {
        return $this->hasMany(Proprietaires::class);
    }
    public function locataires()
    {
        return $this->hasMany(Locataires::class);
    }
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
    public function paiements()
    {
        return $this->hasMany(Paiements::class);
    }
    public function documents()
    {
        return $this->hasMany(Documents::class);

    }
}
