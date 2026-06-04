<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    //
    public function index()
{
    $user = auth()->user();

    // 🔒 On récupère seulement SON enseignant
    $enseignants = \App\Models\User::where('id', $user->id)->with('classe')->get();

    return view('enseignants.index', compact('enseignants'));
}
}
