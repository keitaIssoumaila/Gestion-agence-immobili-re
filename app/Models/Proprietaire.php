<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model
{
    use HasFactory;

    // Indiquer la table associée
    protected $table = 'proprietaires';

    // Autoriser l'ajout en masse des champs suivants
    protected $fillable = ['nom', 'prenom', 'email', 'genre', 'telephone', 'adresse', 'agence_id'
                        ];

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // Relation : Un propriétaire peut avoir plusieurs biens
    public function biens()
    {
        return $this->hasMany(Bien::class);
    }
}
