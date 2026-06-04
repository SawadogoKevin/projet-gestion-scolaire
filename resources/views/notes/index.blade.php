<x-app-layout>

    @php
        $user = auth()->user();
    @endphp

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            🧾 Gestion des notes
        </h1>

        @if($user->role === 'enseignant' && $user->classe_id)
            <a href="{{ route('notes.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-center w-full sm:w-auto">
                + Ajouter
            </a>
        @endif
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm mb-6 space-y-4">

        <h2 class="font-semibold text-gray-700">📊 Relevés & Bulletins</h2>

        <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-3">
            @foreach($classes as $classe)
                <a href="{{ route('notes.releve', $classe->id) }}"
                   class="bg-gray-200 px-3 py-2 rounded-lg hover:bg-gray-300 text-center text-sm font-medium">
                    {{ $classe->nom }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:flex gap-3 pt-2 border-t border-gray-100">
            <a href="{{ route('bulletins.classe') }}"
               class="bg-purple-500 text-white px-3 py-2 rounded-lg hover:bg-purple-600 text-center text-sm font-medium">
                📄 Bulletins
            </a>

            @if($user->role === 'enseignant' && $user->classe_id)
                <a href="{{ route('notes.edit', 0) }}"
                   class="bg-yellow-400 text-white px-3 py-2 rounded-lg hover:bg-yellow-500 text-center text-sm font-medium text-gray-900">
                    Modifier notes
                </a>
            @endif
        </div>

    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead class="bg-gray-100 text-left">
                <tr class="text-gray-700 font-bold">
                    <th class="p-4 font-bold">Élève</th>
                    <th class="p-4 font-bold">Matière</th>
                    <th class="p-4 font-bold">Note</th>
                    <th class="p-4 font-bold">Trimestre</th>
                    
                </tr>
            </thead>

            <tbody>

                @foreach($notes as $note)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4 font-medium whitespace-nowrap">
                        @if($note->eleve)
                            {{ $note->eleve->nom }} {{ $note->eleve->prenom }}
                            @if($note->eleve->trashed())
                                <span class="text-xs text-red-500 font-normal">(Archivé)</span>
                            @endif
                        @else
                            <span class="text-xs text-gray-400 font-normal">Élève introuvable</span>
                        @endif
                    </td>

                    <td class="p-4 whitespace-nowrap">
                        {{ $note->matiere ? $note->matiere->nom : 'Non définie' }}
                    </td>

                    <td class="p-4 font-bold text-blue-600">
                        {{ $note->note }}
                    </td>

                    <td class="p-4">
                        T{{ $note->trimestre }}
                    </td>

                    

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>