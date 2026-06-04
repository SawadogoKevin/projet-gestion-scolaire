<?php

namespace App\Http\Controllers;

// Importation des outils de Laravel pour gérer les requêtes
use Illuminate\Http\Request;
// Importation de tous les modèles nécessaires au projet
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Afficher la liste de toutes les notes (Page d'accueil des notes)
     */
   

public function index()
{
    $enseignant = Auth::user();

    // récupérer uniquement SA classe
    $classe = $enseignant->classe;

    //  SI PAS DE CLASSE
    if (!$classe) {
        return back()->with('error', 'Aucune classe ne vous est affectée');
    }


    // affichage
    $classes = Classe::where('id', $classe->id)->get();

    // On récupère uniquement les notes non supprimées, 
    //  récupérer uniquement les notes de SA classe
    $notes = Note::whereHas('eleve', function ($query) use ($classe) {
        $query->whereNull('deleted_at')
              ->where('classe_id', $classe->id);
    })
    ->with('eleve')
    ->get();

    return view('notes.index', compact('notes', 'classes'));
}




    public function create()
    {
        $enseignant = Auth::user();
    
        // 🔴 Vérifie que l'enseignant a une classe
        if (!$enseignant->classe) {
            abort(403, 'Aucune classe assignée');
        }
    
        $classe = $enseignant->classe;
    
        $eleves = $classe->eleves;
    
        $matieres = $classe->matieres ?? [];
    
        return view('notes.create', compact('classe', 'eleves', 'matieres'));
    }
    /**
     * Enregistrer toutes les notes reçues du formulaire d'un coup
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // VERIFICATION DE SECURITE : On s'assure que toutes les données cruciales sont présentes
        $request->validate([
            'matiere_id' => 'required', // La matière est obligatoire
            'trimestre'  => 'required', // Le trimestre est obligatoire 
            'notes'      => 'required|array', // Les notes doivent être envoyées sous forme de tableau
        ]);

         //  Utilisateur connecté
    $user = auth()->user();

    $classe = $user->classe;

if (!$classe) {
    abort(403, 'Aucune classe assignée');
}

   //  Vérifier si des notes existent déjà
$existe = \App\Models\Note::where('matiere_id', $request->matiere_id)
    ->where('trimestre', $request->trimestre)
    ->whereIn('eleve_id', array_keys($request->notes))
    ->exists();

if ($existe) {
    return back()->with('error', '❌ Des notes existent déjà pour cette matière et ce trimestre');
}

        // Boucle sur le tableau des notes (Clé : ID de l'élève, Valeur : La note saisie)
        foreach ($request->notes as $eleve_id => $note) {
     
            // Si le champ de la note a été laissé vide, on ignore cet élève et on passe au suivant
            if ($note === null) {
                continue;
            }
     
            
            Note::create([
                'eleve_id' => $eleve_id,
                'matiere_id' => $request->matiere_id,
                'trimestre' => $request->trimestre,
                'note' => $note
            ]);
        }
     
        // Rediriger l'utilisateur vers la page de la liste avec un message de succès
       // return back()->with('success', 'Notes enregistrées avec succès');
       return redirect()->route('notes.index')->with('success', 'Notes enregistrées avec succès');
    
    }

    /**
     * Afficher les détails d'une note spécifique (Non utilisé ici)
     */
    public function show(string $id)
    {
        //
    }

    

public function edit($id)
{
$enseignant = auth()->user();


if (!$enseignant->classe) {
    abort(403);
}

$classe = $enseignant->classe;
$matieres = $classe->matieres;

return view('notes.edit', compact('classe', 'matieres'));


}


public function editGroup()
{
    $enseignant = Auth::user();

    $classe = $enseignant->classe;

    // récupérer les élèves avec leurs notes
    $eleves = $classe->eleves()->with('notes')->get();

    return view('notes.edit', compact('eleves'));
}
    /**
     * Mettre à jour une note spécifique qui a été modifiée indiduellement
     */
    public function update(Request $request, $id)
    {
        // Validation stricte des données reçues pour la modification
        $request->validate([
            'eleve_id'   => 'required', // L'élève est obligatoire
            'matiere_id' => 'required', // La matière est obligatoire
            'note'       => 'required|numeric|min:0|max:20', // La note doit être un nombre entre 0 et 20
            'trimestre'  => 'required|in:1,2,3', // Le trimestre doit être soit 1, 2 ou 3
        ]);

        // Trouver la note existante à modifier
        $note = Note::findOrFail($id);

        // Appliquer les changements dans la base de données (Correction du bug de frappe faite ici)
        $note->update([
            'eleve_id'   => $request->eleve_id,
            'matiere_id' => $request->matiere_id, // CORRIGÉ : 'matiere_i' est devenu 'matiere_id'
            'note'       => $request->note,
            'trimestre'  => $request->trimestre,
        ]);

        // Rediriger vers la liste des notes avec un message de succès
        return redirect()->route('notes.index')
            ->with('success', 'Note mise à jour avec succès');
    }

    /**
     * Supprimer une note définitivement de la base de données
     */
    public function destroy($id)
    {
        // Trouver la note à supprimer
        $note = Note::findOrFail($id);

        // Supprimer la note de la base de données
        $note->delete();

        // Rediriger vers la page d'accueil avec un message de confirmation
        return redirect()->route('notes.index')
            ->with('success', 'Note supprimée avec succès');
    }

    /**
     * Méthode alternative pour afficher un formulaire de saisie filtré
     */
    public function storeForm(Request $request)
    {
        // Récupérer uniquement les élèves qui appartiennent à la classe sélectionnée
        $eleves = \App\Models\Eleve::where('classe_id', $request->classe_id)->get();

        // Récupérer les informations de la matière sélectionnée
        $matiere = \App\Models\Matiere::findOrFail($request->matiere_id);

        // Renvoyer les informations vers une vue de saisie spécifique
        return view('notes.saisie', [
            'eleves'    => $eleves,
            'matiere'   => $matiere,
            'trimestre' => $request->trimestre
        ]);
    }

    public function releve($classe_id)
{
    // ============================
    // RECUPERER CLASSE
    // ============================
    $classe = \App\Models\Classe::findOrFail($classe_id);

    // ============================
    // RECUPERER MATIERES
    // ============================
    $matieres = \App\Models\Matiere::where('classe_id', $classe_id)->get();

    // ============================
    // RECUPERER ELEVES + NOTES
    // ============================
    $eleves = \App\Models\Eleve::where('classe_id', $classe_id)
                ->with(['notes.matiere'])
                ->get();

    // envoyer à la vue
    return view('notes.releve', compact('classe', 'matieres', 'eleves'));
}
// =========================================================================
// 1. CHARGER LES ELEVES ET LEURS NOTES EXISTANTES (Pour le JavaScript)
// =========================================================================



public function getNotesExistantes($classe_id, $matiere_id, $trimestre)
{
    $user = auth()->user();

    // 🔒 Sécurité
    if ($user->classe->id != $classe_id) {
        abort(403, 'Accès refusé');
    }

    $eleves = Eleve::where('classe_id', $classe_id)->get();

    $reponse = [];

    foreach ($eleves as $eleve) {

        $noteExistante = Note::where('eleve_id', $eleve->id)
            ->where('matiere_id', $matiere_id)
            ->where('trimestre', $trimestre)
            ->first();

        $reponse[] = [
            'id' => $eleve->id,
            'nom' => $eleve->nom,
            'prenom' => $eleve->prenom,
            'note_existante' => $noteExistante ? $noteExistante->note : null
        ];
    }

    return response()->json($reponse);
}

// =========================================================================
// 2. ENREGISTRER LA MISE A JOUR GROUPEE DES NOTES
// =========================================================================



public function updateGrouped(Request $request)
{
// 🔒 Récupérer l'enseignant connecté
$enseignant = auth()->user();


// 🔒 Vérifier qu'il a une classe
if (!$enseignant->classe) {
    abort(403, 'Aucune classe assignée');
}

$classeId = $enseignant->classe->id;

//  Validation améliorée
$request->validate([
    'matiere_id' => 'required|exists:matieres,id',
    'trimestre' => 'required|in:1,2,3',
    'notes' => 'required|array',
    'notes.*' => 'nullable|numeric|min:0|max:20'
]);

foreach ($request->notes as $eleve_id => $note) {

    // 🔒 Vérifier que l'élève appartient à la classe de l'enseignant
    $eleve = \App\Models\Eleve::where('id', $eleve_id)
                ->where('classe_id', $classeId)
                ->first();

    if (!$eleve) {
        continue; // ignore si élève non autorisé
    }

    // 🧹 Si champ vide → supprimer la note
    if ($note === null || $note === '') {
        \App\Models\Note::where([
            'eleve_id' => $eleve_id,
            'matiere_id' => $request->matiere_id,
            'trimestre' => $request->trimestre
        ])->delete();

        continue;
    }

    // 💾 Mise à jour ou création
    \App\Models\Note::updateOrCreate(
        [
            'eleve_id' => $eleve_id,
            'matiere_id' => $request->matiere_id,
            'trimestre' => $request->trimestre
        ],
        [
            'note' => $note
        ]
    );
}

return redirect()
    ->route('notes.index')
    ->with('success', 'Les notes ont été mises à jour avec succès ✅');


}


// =======================
// BULLETIN NORMAL
// =======================
public function bulletin($id)
{
    $eleve = Eleve::findOrFail($id);
    $classe = $eleve->classe;

    $eleves = Eleve::where('classe_id', $classe->id)->get();

    $classement = [];

    foreach ($eleves as $e) {

        $notes = Note::where('eleve_id', $e->id)
                    ->with('matiere')
                    ->get();

        $total = 0;
        $coefTotal = 0;

        foreach ($notes as $note) {
            $coef = $note->matiere->coefficient ?? 1;
            $total += $note->note * $coef;
            $coefTotal += $coef;
        }

        $moyenne = $coefTotal > 0 ? ($total / $coefTotal) / 2 : 0;

        $classement[] = [
            'eleve_id' => $e->id,
            'moyenne' => $moyenne
        ];
    }

    // TRI
    usort($classement, function ($a, $b) {
        return $b['moyenne'] <=> $a['moyenne'];
    });

    // TROUVER LE RANG
    $rang = 0;

    foreach ($classement as $index => $c) {
        if ($c['eleve_id'] == $eleve->id) {
            $rang = $index + 1;
            break;
        }
    }

    // notes de l'élève courant
    $notes = Note::where('eleve_id', $id)
                ->with('matiere')
                ->get();

    return view('notes.bulletin', compact('eleve', 'classe', 'notes', 'rang'));
}

// =======================
// BULLETIN PDF
// =======================
public function bulletinPDF($eleve_id)
{
    $eleve = Eleve::with('classe')->findOrFail($eleve_id);
    $classe = $eleve->classe;

    // récupérer tous les élèves de la classe
    $eleves = Eleve::where('classe_id', $classe->id)->get();

    $classement = [];

    foreach ($eleves as $e) {

        $notes = Note::where('eleve_id', $e->id)
                    ->with('matiere')
                    ->get();

        $total = 0;
        $coefTotal = 0;

        foreach ($notes as $note) {
            $coef = $note->matiere->coefficient ?? 1;
            $total += $note->note * $coef;
            $coefTotal += $coef;
        }

        $moyenne = $coefTotal > 0 ? ($total / $coefTotal) / 2: 0;

        $classement[] = [
            'eleve_id' => $e->id,
            'moyenne' => $moyenne
        ];
    }

    // trier
    usort($classement, fn($a, $b) => $b['moyenne'] <=> $a['moyenne']);

    // trouver rang
    $rang = 0;
    foreach ($classement as $index => $c) {
        if ($c['eleve_id'] == $eleve->id) {
            $rang = $index + 1;
            break;
        }
    }

    // notes élève
    $notes = Note::where('eleve_id', $eleve_id)
                ->with('matiere')
                ->get();

    $pdf = Pdf::loadView('notes.bulletin', compact('eleve', 'classe', 'notes', 'rang'));

    return $pdf->download('bulletin_'.$eleve->nom.'.pdf');
}
public function choisirClasse()
{
    $classes = Classe::all();

    return view('notes.choisir_classe', compact('classes'));
}

public function bulletinsParClasse($id)
{
    // récupérer la classe + élèves
    $classe = Classe::with('eleves')->findOrFail($id);

    return view('notes.bulletins_classe', compact('classe'));
}

public function bulletinsClassePDF($id)
{
    $classe = Classe::with('eleves')->findOrFail($id);

    $bulletins = [];

    // 1. calculer moyenne pour chaque élève
    foreach ($classe->eleves as $eleve) {

        $notes = Note::with('matiere')
            ->where('eleve_id', $eleve->id)
            ->get();

        $total = 0;
        $coefTotal = 0;

        foreach ($notes as $note) {
            $coef = $note->matiere->coefficient ?? 1;
            $total += $note->note * $coef;
            $coefTotal += $coef;
        }

        $moyenne = $coefTotal > 0 ? ($total / $coefTotal)/2: 0;

        $bulletins[] = [
            'eleve' => $eleve,
            'notes' => $notes,
            'moyenne' => $moyenne
        ];
    }

    // 2. trier par moyenne décroissante
    usort($bulletins, function ($a, $b) {
        return $b['moyenne'] <=> $a['moyenne'];
    });

    // 3. ajouter rang
    foreach ($bulletins as $index => $b) {
        $bulletins[$index]['rang'] = $index + 1;
    }

    $pdf = Pdf::loadView('notes.bulletins_pdf', compact('classe', 'bulletins'));

    return $pdf->download('bulletins_classe_'.$classe->nom.'.pdf');
}
}

