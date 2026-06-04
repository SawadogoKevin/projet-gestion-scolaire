<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// importer SoftDeletes
use Illuminate\Database\Eloquent\SoftDeletes;

class Matiere extends Model
{
    // activer la suppression logique
    use SoftDeletes;

    // champs autorisés pour insertion
    protected $fillable = ['nom', 'coefficient', 'classe_id'];

    // relation : une matière appartient à une classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}