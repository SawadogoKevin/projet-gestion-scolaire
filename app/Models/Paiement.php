<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    //
    // Champs autorisés
protected $fillable = [
    'eleve_id',
    'montant',
    'date_paiement'
];
    public function eleve()
{
    return $this->belongsTo(Eleve::class);
}
}
