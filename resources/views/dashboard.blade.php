<x-app-layout>

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <h1 class="text-2xl font-bold text-gray-800">
        📊 Tableau de bord
    </h1>

    @if(auth()->user()->role !== 'enseignant')

    <!-- 💰 STATS -->
    <div class="grid grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl shadow p-5">
            <p class="text-gray-500">Frais attendus</p>
            <h2 class="text-2xl font-bold text-blue-600">
                {{ number_format($totalAttendu) }} FCFA
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <p class="text-gray-500">Total payé</p>
            <h2 class="text-2xl font-bold text-green-600">
                {{ number_format($totalPaye) }} FCFA
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <p class="text-gray-500">Reste à payer</p>
            <h2 class="text-2xl font-bold text-red-600">
                {{ number_format($reste) }} FCFA
            </h2>
        </div>

    </div>

    <!-- 📊 GRAPH -->
    <div class="bg-white rounded-2xl shadow p-5 mb-6 text-center">

        <h2 class="font-bold mb-4">💰 Répartition financière</h2>

        <div style="width: 250px; margin: auto;">
            <canvas id="doughnutChart"></canvas>
        </div>

    </div>

    @endif


    <!-- 🏆 CLASSEMENT -->
    @foreach($classements as $bloc)

    <div class="bg-white rounded-2xl shadow p-5">

        <h2 class="text-lg font-bold mb-4">
            🏫 Classe : {{ $bloc['classe']->nom }}
        </h2>

        <table class="w-full text-sm">
            <tr class="text-gray-500 text-left border-b">
                <th>Rang</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Moyenne</th>
            </tr>

            @foreach($bloc['eleves'] as $index => $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 font-bold">{{ $index + 1 }}</td>
                <td>{{ $item['eleve']->nom }}</td>
                <td>{{ $item['eleve']->prenom }}</td>
                <td class="text-blue-600 font-bold">
                    {{ number_format($item['moyenne']/2, 2) }}
                </td>
            </tr>
            @endforeach

        </table>

    </div>

    @endforeach


    <!-- 🔴 AUCUN PAIEMENT -->
    <div class="bg-white rounded-2xl shadow p-5 mb-6">

        <h2 class="text-lg font-bold text-red-600 mb-4">
            🔴 Aucun paiement
        </h2>

        @forelse($impayesTotal as $eleve)

            <div class="flex justify-between border-b py-2">
                <span>
                    {{ $eleve->nom }} {{ $eleve->prenom }}
                </span>

                <span class="text-gray-500">
                    {{ $eleve->classe->nom ?? '-' }}
                </span>
            </div>

        @empty

            <p class="text-green-600">
                Aucun élève dans ce cas ✅
            </p>

        @endforelse

    </div>


    <!-- 🟠 PAIEMENT INCOMPLET -->
    <div class="bg-white rounded-2xl shadow p-5 mb-6">

        <h2 class="text-lg font-bold text-orange-500 mb-4">
            🟠 Paiement incomplet
        </h2>

        @forelse($impayesPartiels as $eleve)

            @php
                $totalPayeEleve = $eleve->paiements->sum('montant');
                $frais = $eleve->classe->frais_scolarite ?? 0;
                $resteEleve = $frais - $totalPayeEleve;
            @endphp

            <div class="flex justify-between border-b py-2">

                <span>
                    {{ $eleve->nom }} {{ $eleve->prenom }}
                </span>

                <span class="text-sm text-gray-500">
                    Reste : {{ number_format($resteEleve) }} FCFA
                </span>

            </div>

        @empty

            <p class="text-green-600">
                Tous les élèves sont à jour ✅
            </p>

        @endforelse

    </div>

</div>

<!-- ✅ SCRIPT UNIQUE (IMPORTANT) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const totalPaye = @json($totalPaye);
    const reste = @json($reste);

    console.log("OK Paye:", totalPaye);
    console.log("OK Reste:", reste);

    const ctx = document.getElementById('doughnutChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Payé', 'Reste'],
            datasets: [{
                data: [totalPaye, reste],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});
</script>

</x-app-layout>