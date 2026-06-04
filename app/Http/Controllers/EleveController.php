<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Classe;

class EleveController extends Controller
{
    // Afficher la liste des élèves
    

public function index(Request $request)
{
    // récupérer toutes les classes (pour le select)
    $classes = Classe::all();

    // récupérer classe sélectionnée
    $classe_id = $request->classe_id;

    // condition : si une classe est sélectionnée
    if ($classe_id) {

        // filtrer les élèves par classe
        $eleves = Eleve::where('classe_id', $classe_id)
                        ->with('classe')
                        ->get();

    } else {

        // sinon afficher tous les élèves
        $eleves = Eleve::with('classe')->get();
    }

    // envoyer données à la vue
    return view('eleves.index', compact('eleves', 'classes', 'classe_id'));
}

    // Afficher le formulaire
    public function create()
    {
        // On récupère toutes les classes pour le select
        $classes = Classe::all();

        return view('eleves.create', compact('classes'));
    }

    // Enregistrer un élève
    public function store(Request $request)
{
    // // validation des champs
    $request->validate([
        'nom' => 'required', // nom obligatoire
        'prenom' => 'required', // prénom obligatoire
        'date_naissance' => 'required', // date obligatoire
        'classe_id' => 'required', // classe obligatoire

        // // photo obligatoire
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // // stocker la photo dans storage/app/public/eleves
    $photoPath = $request->file('photo')->store('eleves', 'public');

    // // création de l'élève avec photo
    Eleve::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'date_naissance' => $request->date_naissance,
        'classe_id' => $request->classe_id,

        // // sauvegarde du chemin de la photo
        'photo' => $photoPath
    ]);

    // // redirection avec message
    return redirect()->route('eleves.index')
        ->with('success', 'Élève ajouté avec succès');
}
    // Afficher formulaire de modification
public function edit($id)
{
    // On récupère l'élève
    $eleve = Eleve::findOrFail($id);

    // On récupère les classes pour le select
    $classes = Classe::all();

    return view('eleves.edit', compact('eleve', 'classes'));
}

// Mettre à jour un élève
public function update(Request $request, $id)
{
    // validation
    $request->validate([
        'nom' => 'required',
        'prenom' => 'required',
        'date_naissance' => 'required',
        'classe_id' => 'required',

        // // photo facultative en update
        'photo' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // récupérer élève
    $eleve = Eleve::findOrFail($id);

    // // vérifier si nouvelle photo
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('eleves', 'public');
        $eleve->photo = $photoPath;
    }

    // mise à jour
    $eleve->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'date_naissance' => $request->date_naissance,
        'classe_id' => $request->classe_id,
        'photo' => $eleve->photo
    ]);

    return redirect()->route('eleves.index')
        ->with('success', 'Élève modifié avec succès');
}
// Supprimer un élève
public function destroy($id)
{
    // récupérer l'élève
    $eleve = Eleve::findOrFail($id);

    // suppression
    $eleve->delete();

    // redirection
    return redirect()->route('eleves.index')
        ->with('success', 'Élève supprimé avec succès');
}
}