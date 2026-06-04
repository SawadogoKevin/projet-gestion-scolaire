<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function affecter(Request $request, User $user)
    {
        // Vérifier que l'utilisateur connecté est gestionnaire
        if (auth()->user()->role !== 'gestionnaire') {
            abort(403);
        }

        // Valider la classe
        $request->validate([
            'classe_id' => 'required|exists:classes,id'
        ]);

        // Affecter la classe à l'utilisateur
        $user->classe_id = $request->classe_id;
        $user->save();

        return redirect()->back()->with('success', 'Enseignant affecté à la classe avec succès');
    }
}