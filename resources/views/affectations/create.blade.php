<x-app-layout>

<div class="container">

    <h2>Affecter {{ $enseignant->name }}</h2>

    <form method="POST" action="{{ route('affectations.store', $enseignant->id) }}">
        @csrf

        <label>Choisir une classe :</label>
        <select name="classe_id">
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}">
                    {{ $classe->nom }}
                </option>
            @endforeach
        </select>

        <br><br>

        <button type="submit">Valider</button>
    </form>

</div>

</x-app-layout>