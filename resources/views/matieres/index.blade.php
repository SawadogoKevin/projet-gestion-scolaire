<h2>Liste des matières</h2>

<!-- // message de succès -->
@if(session('success'))
    <div style="color:green;">
        {{ session('success') }}
    </div>
@endif

<!-- // lien ajouter -->
<a href="{{ route('matieres.create') }}">Ajouter une matière</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Coefficient</th>
        <th>Classe</th>
        <th>Actions</th>
    </tr>

    @foreach($matieres as $matiere)
    <tr>
        <td>{{ $matiere->id }}</td>
        <td>{{ $matiere->nom }}</td>
        <td>{{ $matiere->coefficient }}</td>
        <td>{{ $matiere->classe->nom }}</td>

        <td>
            <!-- // bouton modifier -->
            <a href="{{ route('matieres.edit', $matiere->id) }}">Modifier</a>

            <!-- // formulaire suppression -->
            <form action="{{ route('matieres.destroy', $matiere->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')

                <!-- // confirmation -->
                <button onclick="return confirm('Supprimer cette matière ?')">
                    Supprimer
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>