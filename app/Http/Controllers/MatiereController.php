<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Matiere;




class MatiereController extends Controller
{
    

// afficher la liste des matières
public function index()
{
    // récupérer toutes les matières avec leur classe
    $matieres = Matiere::with('classe')->get();

    // envoyer à la vue
    return view('matieres.index', compact('matieres'));
}
    /**
     * Show the form for creating a new resource.
     */

// afficher le formulaire de création d'une matière
public function create()
{
    // récupérer toutes les classes depuis la base
    $classes = Classe::all();

    // envoyer les classes à la vue
    return view('matieres.create', compact('classes'));
}

    /**
     * Store a newly created resource in storage.
     */
    
// enregistrer une matière
public function store(Request $request)
{
    // validation des données
    $request->validate([

        // nom obligatoire et unique par classe
        'nom' => 'required|unique:matieres,nom,NULL,id,classe_id,' . $request->classe_id,
    
        'coefficient' => 'required|numeric|min:1',
        'classe_id' => 'required'
    
    ], [
    
        // message personnalisé
        'nom.unique' => 'Cette matière existe déjà dans cette classe.',
        'nom.required' => 'Le nom de la matière est obligatoire.',
        'coefficient.required' => 'Le coefficient est obligatoire.'
    ]);

    // création de la matière en base
    Matiere::create([
        'nom' => $request->nom,
        'coefficient' => $request->coefficient,
        'classe_id' => $request->classe_id
    ]);

    // redirection avec message de succès
    return redirect()->route('matieres.create')
        ->with('success', 'Matière ajoutée avec succès');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

// afficher formulaire modification
public function edit($id)
{
    // récupérer la matière
    $matiere = Matiere::findOrFail($id);

    // récupérer les classes
    $classes = Classe::all();

    // envoyer à la vue
    return view('matieres.edit', compact('matiere', 'classes'));
}
    /**
     * Update the specified resource in storage.
     */
    // mettre à jour une matière
public function update(Request $request, $id)
{
    // validation
    $request->validate([
        'nom' => 'required',
        'coefficient' => 'required|integer|min:1',
        'classe_id' => 'required'
    ]);

    // récupérer la matière
    $matiere = Matiere::findOrFail($id);

    // mise à jour
    $matiere->update([
        'nom' => $request->nom,
        'coefficient' => $request->coefficient,
        'classe_id' => $request->classe_id
    ]);

    return redirect()->route('matieres.index')
        ->with('success', 'Matière modifiée avec succès');
}

    
    // suppression logique
public function destroy($id)
{
    $matiere = Matiere::findOrFail($id);

    $matiere->delete(); // NE SUPPRIME PAS vraiment

    return redirect()->route('matieres.index')
        ->with('success', 'Matière supprimée (soft delete)');
}
}
