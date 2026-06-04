<x-app-layout>

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            💰 Liste des paiements
        </h1>
        <a href="{{ route('paiements.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-center w-full sm:w-auto">
            + Ajouter
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead class="bg-gray-100 text-left">
                <tr class="text-gray-700 font-bold">
                    <th class="p-4 font-bold">ID</th>
                    <th class="p-4 font-bold">Élève</th>
                    <th class="p-4 font-bold">Montant</th>
                    <th class="p-4 font-bold">Date</th>
                    <th class="p-4 font-bold">Reçu</th>
                </tr>
            </thead>

            <tbody>

                @foreach($paiements as $paiement)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4">{{ $paiement->id }}</td>

                    <td class="p-4 font-medium whitespace-nowrap">
                        {{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}
                    </td>

                    <td class="p-4 text-green-600 font-semibold whitespace-nowrap">
                        {{ $paiement->montant }} FCFA
                    </td>

                    <td class="p-4 whitespace-nowrap">
                        {{ $paiement->date_paiement }}
                    </td>

                    <td class="p-4">
                        <a href="{{ route('paiements.recu', $paiement->id) }}"
                           class="bg-purple-500 text-white px-3 py-1 rounded-lg hover:bg-purple-600 text-sm inline-flex items-center gap-1 whitespace-nowrap">
                            📄 Télécharger
                        </a>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>
</x-app-layout>