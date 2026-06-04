<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Note extends Model
{
    use HasFactory;
    use SoftDeletes;

    // =========================================================================
    // AUTORISATION DES CHAMPS (Mass Assignment)
    // C'est cette ligne qui autorise Laravel à enregistrer ces données en base
    // =========================================================================
    protected $fillable = [
        'eleve_id',   // Autorise l'enregistrement de l'ID de l'élève
        'matiere_id', // Autorise l'enregistrement de l'ID de la matière
        'trimestre',  // Autorise l'enregistrement du trimestre
        'note',       // Autorise l'enregistrement de la note elle-même
    ];

    // =========================================================================
    // RELATION ENTRE LA NOTE ET L'ÉLÈVE
    // Chaque note appartient à un élève
    // =========================================================================
    public function eleve()
    {
        return $this->belongsTo(Eleve::class)->withTrashed();
    }

    // relation avec matière
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}