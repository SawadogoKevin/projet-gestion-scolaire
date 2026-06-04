<x-app-layout>

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            📚 Liste des classes
        </h1>

        <a href="{{ route('classes.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-center w-full sm:w-auto">
            + Ajouter
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-x-auto">

        <table class="w-full min-w-[600px]">

            <thead class="bg-gray-100 text-left">
                <tr class="text-gray-700 font-bold">
                    <th class="p-4 font-bold">ID</th>
                    <th class="p-4 font-bold">Nom</th>
                    <th class="p-4 font-bold">Frais</th>
                    <th class="p-4 font-bold">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($classes as $classe)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4">{{ $classe->id }}</td>

                    <td class="p-4 font-medium">
                        <a href="{{ route('classes.show', $classe->id) }}"
                           class="text-blue-600 hover:underline whitespace-nowrap">
                            {{ $classe->nom }}
                        </a>
                    </td>

                    <td class="p-4 whitespace-nowrap">
                        {{ $classe->frais_scolarite }} FCFA
                    </td>

                    <td class="p-4 flex gap-2 items-center">

                        <a href="{{ route('classes.edit', $classe->id) }}"
                           class="bg-yellow-400 px-3 py-1 rounded text-white hover:bg-yellow-500 text-sm">
                            Modifier
                        </a>

                        <form action="{{ route('classes.destroy', $classe->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Supprimer cette classe ?')">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600 text-sm">
                                Supprimer
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>