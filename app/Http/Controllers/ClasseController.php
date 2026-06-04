<?php

namespace App\Http\Controllers; 
// Définit le "namespace" (espace de noms)
// Cela permet à Laravel de savoir où se trouve ce contrôleur dans le projet

use Illuminate\Http\Request; 
// Importe la classe Request qui permet de récupérer les données envoyées par un formulaire

use App\Models\Classe; 
// Importe le modèle Classe pour interagir avec la table "classes" dans la base de données

use App\Models\Matiere;
use Illuminate\Validation\Rule;

class ClasseController extends Controller
// Déclaration de la classe ClasseController qui hérite de Controller (classe de base Laravel)
{
    public function index()
    {
        $classes = Classe::all(); 
        // Récupère toutes les classes depuis la base de données (SELECT * FROM classes)



        return view('classes.index', compact('classes')); 
        // Retourne la vue "classes/index.blade.php"
        // compact('classes') envoie la variable $classes à la vue
    }

    public function create()
    {
        $classes = Classe::all();

        return view('classes.create'); 
        // Retourne la vue contenant le formulaire pour ajouter une classe
    }


    public function store(Request $request)
    {
        // =========================
        // VALIDATION SIMPLE
        // =========================
        $request->validate([
            'nom' => 'required',
            'frais' => 'required|numeric',
    
            'matieres.*.nom' => 'required',
            'matieres.*.coefficient' => 'required|numeric|min:1',
        ]);
    
        // =========================
        // VERIFIER DOUBLONS
        // =========================
        $noms = [];
    
        foreach ($request->matieres as $matiere) {
    
            $clean = strtolower(trim($matiere['nom']));
    
            if (in_array($clean, $noms)) {
                return back()->withErrors([
                    'error' => "La matière \"{$matiere['nom']}\" existe déjà"
                ])->withInput();
            }
    
            $noms[] = $clean;
        }
    
        // =========================
        // CREATION CLASSE
        // =========================
        $classe = Classe::create([
            'nom' => $request->nom,
            'frais_scolarite' => $request->frais
        ]);
    
        // =========================
        // CREATION MATIERES
        // =========================
        foreach ($request->matieres as $matiere) {
    
            Matiere::create([
                'nom' => $matiere['nom'],
                'coefficient' => $matiere['coefficient'],
                'classe_id' => $classe->id
            ]);
        }
    
        return redirect()->route('classes.index')
            ->with('success', 'Classe créée avec succès');
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        // récupérer classe avec matières
        $classe = \App\Models\Classe::with('matieres')->findOrFail($id);
    
        return view('classes.edit', compact('classe'));
    }

// Mettre à jour une classe
public function update(Request $request, $id)
{
    // =========================
    // VALIDATION
    // =========================
    $request->validate([
        'nom' => 'required',
        'frais' => 'required|numeric'
    ]);

    // =========================
    // RECUPERER LA CLASSE
    // =========================
    $classe = Classe::findOrFail($id);

    // =========================
    // MISE A JOUR
    // =========================
    $classe->update([
        'nom' => $request->nom,
        'frais_scolarite' => $request->frais 
    ]);

    return redirect()->route('classes.index')
        ->with('success', 'Classe modifiée avec succès');
}

// Supprimer une classe
// supprimer une classe
public function destroy($id)
{
    // récupérer la classe
    $classe = Classe::findOrFail($id);

    // suppression
    $classe->delete();

    // redirection avec message
    return redirect()->route('classes.index')
        ->with('success', 'Classe supprimée avec succès');
}


public function show($id)
{
    // récupérer classe avec ses matières
    $classe = Classe::with('matieres')->findOrFail($id);

    // envoyer à la vue
    return view('classes.show', compact('classe'));
}

}