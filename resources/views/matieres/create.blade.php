<h2>Ajouter une matière</h2>

<!-- // message de succès -->
@if(session('success'))
    <div style="color:green;">
        {{ session('success') }}
    </div>
@endif

<!-- // formulaire d'ajout -->
<form action="{{ route('matieres.store') }}" method="POST">
    @csrf <!-- // protection CSRF -->

    <!-- // champ nom de la matière -->
    <label>Nom :</label>
    <input type="text" name="nom" required>
    @error('nom')
    <div style="color:red;">
        {{ $message }}
    </div>
@enderror

    <!-- // champ coefficient -->
    <label>Coefficient :</label>
    <input type="number" name="coefficient" required>

    <!-- // sélection de la classe -->
    <label>Classe :</label>
    <select name="classe_id" required>
        <option value="">-- Choisir une classe --</option>

        @foreach($classes as $classe)
            <!-- // chaque matière sera liée à une classe -->
            <option value="{{ $classe->id }}">
                {{ $classe->nom }}
            </option>
        @endforeach
    </select>

    <!-- // bouton de soumission -->
    <button type="submit">Enregistrer</button>
</form>