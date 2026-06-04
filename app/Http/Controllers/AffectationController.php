<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    // PAGE INDEX (liste enseignants)
    public function index()
    {
        // récupérer les enseignants avec leur classe
        $enseignants = User::where('role', 'enseignant')
            ->with('classe')
            ->get();

        return view('affectations.index', compact('enseignants'));
    }

    //  FORMULAIRE D’AFFECTATION (pour 1 enseignant)
    public function create($id)
    {
        $enseignant = User::findOrFail($id);

        // récupérer les classes
        $classes = Classe::all();

        return view('affectations.create', compact('enseignant', 'classes'));
    }

    //  ENREGISTRER AFFECTATION
    public function store(Request $request, $id)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id'
        ]);

        $user = User::findOrFail($id);

        $user->classe_id = $request->classe_id;
        $user->save();

        return redirect()->route('affectations.index')
            ->with('success', 'Affectation réussie');
    }
    //  RETIRER UNE AFFECTATION
public function destroy($id)
{
    $user = User::findOrFail($id);

    // supprimer l'affectation
    $user->classe_id = null;
    $user->save();

    return redirect()->route('affectations.index')
        ->with('success', 'Affectation retirée');
}
}