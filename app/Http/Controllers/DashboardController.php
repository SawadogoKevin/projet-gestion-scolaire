<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Paiement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //  TOTAL ATTENDU 
        $totalAttendu = DB::table('eleves')
            ->join('classes', 'eleves.classe_id', '=', 'classes.id')
            ->sum('classes.frais_scolarite');

        //  TOTAL PAYÉ
        $totalPaye = Paiement::sum('montant');

        //  RESTE
        $reste = $totalAttendu - $totalPaye;

        //  CLASSEMENT PAR CLASSE
        $classes = Classe::with('eleves.notes.matiere')->get();

        $classements = [];

        foreach ($classes as $classe) {

            $classement = $classe->eleves->map(function ($eleve) {

                $total = 0;
                $coefTotal = 0;

                foreach ($eleve->notes as $note) {
                    $coef = $note->matiere->coefficient ?? 1;
                    $total += $note->note * $coef;
                    $coefTotal += $coef;
                }

                $moyenne = $coefTotal > 0 ? $total / $coefTotal : 0;

                return [
                    'eleve' => $eleve,
                    'moyenne' => $moyenne
                ];
            })
            ->sortByDesc('moyenne')
            ->values();

            $classements[] = [
                'classe' => $classe,
                'eleves' => $classement
            ];
        }

        // 🔴 Élèves sans paiement
        $impayesTotal = Eleve::with('classe')
            ->doesntHave('paiements')
            ->get();

        // 🟠 Paiements incomplets
        $impayesPartiels = Eleve::with('paiements', 'classe')
            ->get()
            ->filter(function ($eleve) {

                $totalPaye = $eleve->paiements->sum('montant');
                $frais = $eleve->classe->frais_scolarite ?? 0;

                return $totalPaye > 0 && $totalPaye < $frais;
            });
            //dd($totalAttendu, $totalPaye, $reste);
        return view('dashboard', compact(
            'totalAttendu',
            'totalPaye',
            'reste',
            'classements',
            'impayesTotal',
            'impayesPartiels'
        ));
    }
}