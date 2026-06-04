<x-app-layout>

<div class="max-w-5xl mx-auto">

    <!-- TITRE + ACTION -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            📄 Bulletins - Classe {{ $classe->nom }}
        </h2>

        <a href="{{ route('bulletins.classe.pdf', $classe->id) }}"
           class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
            📥 Télécharger PDF
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Prénom</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($classe->eleves as $eleve)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3 font-medium text-gray-700">
                        {{ $eleve->nom }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $eleve->prenom }}
                    </td>

                    <td class="p-3 text-right space-x-2">

                        <a href="{{ route('notes.bulletin', $eleve->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">
                            Voir
                        </a>

                        <a href="{{ route('notes.bulletin.pdf', $eleve->id) }}"
                           class="bg-gray-700 text-white px-3 py-1 rounded-lg hover:bg-gray-800">
                            PDF
                        </a>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    <!-- BOUTON RETOUR -->
    <div class="flex justify-end mt-6">

        <a href="{{ url()->previous() }}"
           class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
            ↩ Retour
        </a>

    </div>

</div>

</x-app-layout>