<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\UserController;


use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Note;
use App\Models\Matiere;

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', function (Request $request) {

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Identifiants incorrects'
    ]);
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| 2. AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

// Déconnexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| 3. ROUTES AUTHENTIFIÉES (TOUS LES UTILISATEURS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
        Route::resource('eleves', EleveController::class);
    /*
    |--------------------------------------------------------------------------
    | AJAX
    |--------------------------------------------------------------------------
    */

    Route::get('/get-matieres/{classe_id}', function ($classe_id) {
        return response()->json(Matiere::where('classe_id', $classe_id)->get());
    });

    Route::get('/get-eleves/{classe_id}', function ($classe_id) {
        return response()->json(Eleve::where('classe_id', $classe_id)->get());
    });

    Route::get('/eleve/{id}/reste', function ($id) {
        $eleve = Eleve::find($id);
        return $eleve ? $eleve->resteAPayer() : 0;
    });

});

/*
|--------------------------------------------------------------------------
| 4. ROUTES GESTIONNAIRE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:gestionnaire'])->group(function () {

    Route::resource('classes', ClasseController::class);
    //Route::resource('eleves', EleveController::class);
    Route::resource('paiements', PaiementController::class);
    // Route pour générer le reçu PDF
Route::get('/paiements/{id}/recu', [PaiementController::class, 'recu'])
->name('paiements.recu');

});

/*
|--------------------------------------------------------------------------
| 5. ROUTES ENSEIGNANT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:enseignant'])->group(function () {

    // Notes
    Route::get('/notes/saisie', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes/saisie', [NoteController::class, 'storeForm'])->name('notes.storeForm');
    Route::post('/notes/save', [NoteController::class, 'store'])->name('notes.store');

    //Route::get('/notes/edit-group', [NoteController::class, 'editGroup'])->name('notes.editGroup');
    Route::put('/notes/update-grouped', [NoteController::class, 'updateGrouped'])
        ->name('notes.updateGrouped');
        
    Route::resource('notes', NoteController::class);
    //Route::resource('eleves', EleveController::class);
    //Route::resource('notes', NoteController::class)->except(['edit', 'update']);

Route::get('/notes/releve/{classe}', [NoteController::class, 'releve'])
    ->name('notes.releve');

/*Route::get('/bulletins', [NoteController::class, 'bulletins'])
    ->name('bulletins.classe');*/

    Route::get('/bulletin/{id}', [NoteController::class, 'bulletin'])
    ->name('notes.bulletin');

Route::get('/bulletin/{id}/pdf', [NoteController::class, 'bulletinPDF'])
    ->name('notes.bulletin.pdf');

// recuperer les notes existantes
   Route::get('/get-notes-existantes/{classe}/{matiere}/{trimestre}', 
    [NoteController::class, 'getNotesExistantes']);
});


/*
|--------------------------------------------------------------------------
| 6. BULLETINS (ENSEIGNANT + GESTIONNAIRE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/bulletins', [NoteController::class, 'choisirClasse'])
        ->name('bulletins.classe');

    Route::get('/bulletins/classe/{id}', [NoteController::class, 'bulletinsParClasse'])
        ->name('bulletins.par.classe');

    Route::get('/bulletins/classe/{id}/pdf', [NoteController::class, 'bulletinsClassePDF'])
        ->name('bulletins.classe.pdf');
        Route::resource('eleves', EleveController::class);

});

/*
|--------------------------------------------------------------------------
| 7. MATIÈRES
|--------------------------------------------------------------------------
*/

/*Route::middleware(['auth', 'role:gestionnaire'])->group(function () {
    Route::resource('matieres', MatiereController::class);
}); */

/*Route::post('/affecter/{user}', [UserController::class, 'affecter'])
    ->middleware('auth');*/


use App\Http\Controllers\AffectationController;


    // Liste des enseignants + affectation
    Route::get('/affectations', [AffectationController::class, 'index'])->name('affectations.index');
    
    // Formulaire affectation
    Route::get('/affectations/{id}/create', [AffectationController::class, 'create'])->name('affectations.create');
    
    // Traitement affectation
    Route::post('/affectations/{id}', [AffectationController::class, 'store'])->name('affectations.store');
    
    // Retirer affectation
Route::delete('/affectations/{id}', [AffectationController::class, 'destroy'])
->name('affectations.destroy');


//
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Test email depuis Laravel 🚀', function ($message) {
        $message->to('sawadogokevin473@gmail.com')
                ->subject('Test Laravel');
    });

    return "Email envoyé";
});