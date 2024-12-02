<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table='documents';

    protected $fillable = [
        'agence_id', 'bien_id', 'contrat_id', 'nom_fichier', 'type_document'
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    // Un contrat est géré par une agence
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
   
}
