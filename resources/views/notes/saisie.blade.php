<form method="POST" action="{{ route('notes.store') }}">
    @csrf

    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Note</th>
        </tr>

        @foreach($eleves as $eleve)
        <tr>
            <td>{{ $eleve->nom }}</td>

            <td>
                <input type="number" name="notes[{{ $eleve->id }}]" step="0.01">
            </td>
        </tr>
        @endforeach
    </table>

    <!-- données cachées -->
    <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
    <input type="hidden" name="trimestre" value="{{ $trimestre }}">

    <button type="submit">Enregistrer</button>
</form>