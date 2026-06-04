<x-app-layout>

<div class="container">

    <h2>Liste des enseignants</h2>

    {{--  MESSAGE SUCCESS --}}
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Classe</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($enseignants as $enseignant)
                <tr>
                    <td>{{ $enseignant->name }}</td>
                    <td>{{ $enseignant->email }}</td>

                    <td>
                        @if($enseignant->classe)
                            {{ $enseignant->classe->nom }}
                        @else
                            <span style="color:red;">Pas encore affecté</span>
                        @endif
                    </td>

                    <td>
                        @if($enseignant->classe)

                            <!-- 🔴 Retirer -->
                            <form action="{{ route('affectations.destroy', $enseignant->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Retirer cette affectation ?')">
                                    Retirer
                                </button>
                            </form>

                        @else

                            <!-- 🟢 Affecter -->
                            <a href="{{ route('affectations.create', $enseignant->id) }}">
                                Affecter
                            </a>

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</x-app-layout>