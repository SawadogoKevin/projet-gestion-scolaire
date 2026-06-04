<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classe extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 🔐 $fillable permet de définir quels champs peuvent être remplis automatiquement
    // (protection contre les attaques de type "mass assignment")
    protected $fillable = [
        'nom',               // nom de la classe (ex: CP1, CE2...)
        'frais_scolarite'   // montant des frais scolaires
    ];

    // 🔗 Relation : une classe possède plusieurs élèves
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    
    }

    // relation : une classe a plusieurs matières
public function matieres()
{
    return $this->hasMany(Matiere::class);
}

protected static function booted()
{
    static::deleting(function ($classe) {
        // Si c'est une suppression définitive
        if ($classe->isForceDeleting()) {
            foreach($classe->eleve()->withTrashed()->get() as $eleve){
            $classe->eleves()->forceDelete();}
        } else {
            // Si c'est un Soft Delete, on applique le Soft Delete aux élèves
            $classe->eleves()->delete();
        }
    });
}
// N'oublie pas de t'assurer que la relation est bien définie dans ce même modèle :

}