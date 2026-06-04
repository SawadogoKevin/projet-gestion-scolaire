<h2>Classe : {{ $classe->nom }}</h2>

<p>Frais : {{ $classe->frais }}</p>

<hr>

<h3>Matières</h3>

<table border="1">
    <tr>
        <th>Matière</th>
        <th>Coefficient</th>
    </tr>

    @foreach($classe->matieres as $matiere)
    <tr>
        <td>{{ $matiere->nom }}</td>
        <td>{{ $matiere->coefficient }}</td>
    </tr>
    @endforeach

</table>