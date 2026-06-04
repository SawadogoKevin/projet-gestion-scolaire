<x-app-layout>

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            📊 Relevé de notes - {{ $classe->nom }}
        </h2>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Prénom</th>

                    @foreach($matieres as $matiere)
                        <th class="p-3 text-center">
                            {{ $matiere->nom }} <br>
                            <span class="text-xs text-gray-400">
                                coef {{ $matiere->coefficient }}
                            </span>
                        </th>
                    @endforeach

                    <th class="p-3 text-center">Total</th>
                    <th class="p-3 text-center">T1</th>
                    <th class="p-3 text-center">T2</th>
                    <th class="p-3 text-center">T3</th>
                    <th class="p-3 text-center">Moyenne Annuelle</th>
                </tr>
            </thead>

            <tbody>

                @foreach($eleves as $eleve)

                @php
                    $total = 0;
                    $coefTotal = 0;

                    $m1 = $eleve->moyenne(1);
                    $m2 = $eleve->moyenne(2);
                    $m3 = $eleve->moyenne(3);
                @endphp

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3 font-medium">{{ $eleve->nom }}</td>
                    <td class="p-3">{{ $eleve->prenom }}</td>

                    @foreach($matieres as $matiere)

                        @php
                            $note = $eleve->notes
                                ->where('matiere_id', $matiere->id)
                                ->first();
                        @endphp

                        <td class="p-3 text-center">
                            {{ $note->note ?? '-' }}
                        </td>

                        @php
                            if($note){
                                $total += $note->note * $matiere->coefficient;
                                $coefTotal += $matiere->coefficient;
                            }
                        @endphp

                    @endforeach

                    <!-- TOTAL -->
                    <td class="p-3 text-center font-semibold">
                        {{ $coefTotal > 0 ? $total : '-' }}
                    </td>

                    <!-- MOYENNES -->
                    <td class="p-3 text-center">
                        {{ $eleve->moyenne(1) ?? 'N/A' }}
                    </td>

                    <td class="p-3 text-center">
                        {{ $eleve->moyenne(2) ?? 'N/A' }}
                    </td>

                    <td class="p-3 text-center">
                        {{ $eleve->moyenne(3) ?? 'N/A' }}
                    </td>
                    <!-- MOYENNE ANNUELLE -->
                    <td class="p-3 text-center font-bold text-blue-600">
                        @if($m1 !== null && $m2 !== null && $m3 !== null)
                            {{ round(($m1 + $m2 + $m3) / 3, 2) }}
                        @else
                            <span class="text-red-500 text-xs">
                                Toutes les moyennes ne sont pas disponibles
                            </span>
                        @endif
                    </td>


                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <!-- BOUTON RETOUR -->
    <div class="flex justify-end mt-6">

        <a href="{{ route('notes.index') }}"
           class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
            ↩ Retour
        </a>

    </div>

</div>

</x-app-layout>