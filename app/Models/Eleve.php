<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Eleve extends Model
{

    use SoftDeletes;
    // Autoriser insertion des champs
protected $fillable = [
    'nom',
    'prenom',
    'date_naissance',
    'photo',
    'classe_id'
];


    //belongsTo → l’élève appartient à une classe
    //hasMany → l’élève a plusieurs paiements et notes
    public function classe()
{
    
    return $this->belongsTo(Classe::class);
}

public function paiements()
{
    return $this->hasMany(Paiement::class);
}

public function notes()
{
    return $this->hasMany(Note::class);
}

protected static function booted()
{
    static::deleting(function ($eleve) {
        // Si c'est une suppression définitive
        if ($eleve->isForceDeleting()) {
            $eleve->notes()->forceDelete();
        } else {
            // Si c'est un Soft Delete, on applique le Soft Delete aux élèves
            $eleve->Notes()->delete();
        }
    });
}
// Calcul du total payé par l'élève
public function totalPaiements()
{
    // somme de tous les paiements
    return $this->paiements->sum('montant');
}

// Calcul du reste à payer
public function resteAPayer()
{
    // frais de la classe - total payé
    return $this->classe->frais_scolarite - $this->totalPaiements();
}


// calcul moyenne pondérée par trimestre
public function moyenne($trimestre)
{
    // ============================
    // NOTES DE L'ELEVE
    // ============================
    $notes = $this->notes()
                  ->where('trimestre', $trimestre)
                  ->with('matiere')
                  ->get();

    // ============================
    // MATIERES DE LA CLASSE
    // ============================
    $matieres = \App\Models\Matiere::where('classe_id', $this->classe_id)->get();

    // ============================
    // VERIFICATION COMPLETE
    // ============================
    foreach ($matieres as $matiere) {

        $noteExiste = $notes->where('matiere_id', $matiere->id)->first();

        if (!$noteExiste) {
            return null; // ou false si tu préfères
        }
    }

    // ============================
    // CALCUL MOYENNE
    // ============================
    $total = 0;
$coefTotal = 0;

foreach ($notes as $note) {

    $coef = $note->matiere->coefficient ?? 0;

    $total += $note->note * $coef;
    $coefTotal += $coef;
}

// moyenne sur 20 puis conversion sur 10
$moyenne = $coefTotal > 0 ? ($total / $coefTotal) : 0;

return round($moyenne / 2, 2);
}

}
