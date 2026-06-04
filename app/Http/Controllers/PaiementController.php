<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Eleve;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon; 

class PaiementController extends Controller
{
    // Afficher la liste des paiements
    public function index()
    {
        // Charger les paiements avec les élèves
        $paiements = Paiement::with('eleve')->get();

        return view('paiements.index', compact('paiements'));
    }

    // Formulaire ajout
   
    public function create()
{
    $classes = \App\Models\Classe::all();
    return view('paiements.create', compact('classes'));
}

    



    // Générer le reçu
public function recu($id)
{
    // Récupérer paiement + élève + classe
    $paiement = Paiement::with('eleve.classe')->findOrFail($id);
    $reste = $paiement->eleve->resteAPayer();

    // Générer le PDF
    $pdf = Pdf::loadView('paiements.recu', compact('paiement', 'reste'));

    // Télécharger
    return $pdf->download('recu_paiement.pdf');
}

// Enregistrer un paiement

public function store(Request $request)
{
    $request->validate([
        'eleve_id' => 'required',
        'montant' => 'required|numeric|min:0'
    ]);

    $eleve = Eleve::findOrFail($request->eleve_id);

    // calcul reste
    $reste = $eleve->resteAPayer();

    //  BLOQUER SI DEPASSEMENT
    if ($request->montant > $reste) {
        return back()->withErrors([
            'error' => 'La somme saisie est supérieure au reste à payer'
        ])->withInput();
    }

    // enregistrer paiement
    Paiement::create([
        'eleve_id' => $eleve->id,
        'montant' => $request->montant,
        'date_paiement' => Carbon::now() 
    ]);
    return redirect()->route('paiements.index')
                 ->with('success', 'Paiement enregistré avec succès');}
}