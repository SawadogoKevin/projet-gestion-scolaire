<x-app-layout>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
            👨‍🎓 Liste des élèves
        </h1>

        @if(auth()->user()->role !== 'enseignant')
        <a href="{{ route('eleves.create') }}"
           class="bg-blue-500 text-white px-3 py-2 sm:px-4 rounded-lg hover:bg-blue-600 text-sm sm:text-base font-medium">
            + Ajouter
        </a>
        @endif
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm mb-6">
        <form method="GET" action="{{ route('eleves.index') }}" class="flex flex-col sm:flex-row gap-3 sm:items-center">

            <select name="classe_id" class="border rounded-lg px-3 py-2 w-full sm:w-auto text-sm bg-white">
                <option value="">-- Choisir une classe --</option>

                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}"
                        {{ $classe_id == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>

            <button class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 text-sm font-medium w-full sm:w-auto">
                Filtrer
            </button>

        </form>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-x-auto">

        <table class="w-full min-w-[750px] sm:min-w-full">

            <thead class="bg-gray-100 text-left text-xs sm:text-sm uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="p-4 w-12">ID</th>
                    <th class="p-4 w-16">Photo</th>
                    <th class="p-4">Nom</th>
                    <th class="p-4">Prénom</th>
                    <th class="p-4">Classe</th>

                    @if(auth()->user()->role !== 'enseignant')
                    <th class="p-4">Payé</th>
                    <th class="p-4">Reste</th>
                    @endif
                    
                    @if(auth()->user()->role !== 'enseignant')
                    <th class="p-4">Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody class="text-sm">

                @foreach($eleves as $eleve)
                <tr class="border-t hover:bg-gray-50 transition duration-150">

                    <td class="p-4 text-gray-500">{{ $eleve->id }}</td>

                    <td class="p-4">
                        @if($eleve->photo)
                            <img src="{{ asset('storage/' . $eleve->photo) }}"
                                 class="w-10 h-10 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs">
                                --
                            </div>
                        @endif
                    </td>

                    <td class="p-4 font-semibold text-gray-900 uppercase">
                        {{ $eleve->nom }}
                    </td>

                    <td class="p-4 text-gray-700 capitalize">
                        {{ $eleve->prenom }}
                    </td>

                    <td class="p-4">
                        <span class="bg-slate-100 text-slate-800 px-2.5 py-1 rounded-full text-xs font-medium">
                            {{ $eleve->classe->nom }}
                        </span>
                    </td>

                    @if(auth()->user()->role !== 'enseignant')
                    <td class="p-4 text-green-600 font-bold whitespace-nowrap">
                        {{ number_format($eleve->totalPaiements(), 0, ',', ' ') }} FCFA
                    </td>

                    <td class="p-4 text-red-500 font-bold whitespace-nowrap">
                        {{ number_format($eleve->resteAPayer(), 0, ',', ' ') }} FCFA
                    </td>
                    @endif

                    @if(auth()->user()->role !== 'enseignant')
                    <td class="p-4">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                            
                            <a href="{{ route('eleves.edit', $eleve->id) }}"
                               class="bg-yellow-400 px-3 py-1.5 rounded-lg text-white hover:bg-yellow-500 font-medium text-xs transition duration-150">
                                Modifier
                            </a>

                            <form action="{{ route('eleves.destroy', $eleve->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Supprimer cet élève ?')">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 px-3 py-1.5 rounded-lg text-white hover:bg-red-600 font-medium text-xs transition duration-150">
                                    Supprimer
                                </button>
                            </form>
                            
                        </div>
                    </td>
                    @endif

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>