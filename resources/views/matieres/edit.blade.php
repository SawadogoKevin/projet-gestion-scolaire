<h2>Modifier une matière</h2>

<form action="{{ route('matieres.update', $matiere->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- // nom -->
    <label>Nom :</label>
    <input type="text" name="nom" value="{{ $matiere->nom }}" required>

    <!-- // coefficient -->
    <label>Coefficient :</label>
    <input type="number" name="coefficient" value="{{ $matiere->coefficient }}" required>

    <!-- // classe -->
    <label>Classe :</label>
    <select name="classe_id" required>
        @foreach($classes as $classe)
            <option value="{{ $classe->id }}"
                {{ $matiere->classe_id == $classe->id ? 'selected' : '' }}>
                {{ $classe->nom }}
            </option>
        @endforeach
    </select>

    <button type="submit">Modifier</button>
</form>