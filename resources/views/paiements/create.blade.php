<x-app-layout>

<div class="max-w-4xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        💳 Effectuer un paiement
    </h2>

    <div class="bg-white p-6 rounded-xl shadow-sm">

        <!-- ERREUR -->
        @if($errors->has('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4">
                {{ $errors->first('error') }}
            </div>
        @endif

        <!-- SUCCESS (optionnel si toast déjà utilisé) -->
        @if(session('success'))
            <div class="bg-green-100 text-green-600 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('paiements.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <!-- CLASSE -->
                <div>
                    <label class="block text-gray-600 mb-1">Classe</label>
                    <select id="classe" name="classe_id"
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choisir</option>

                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->nom }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- ELEVE -->
                <div>
                    <label class="block text-gray-600 mb-1">Élève</label>
                    <select name="eleve_id" id="eleve"
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choisir un élève</option>
                    </select>
                </div>

            </div>

            <!-- RESTE -->
            <div class="mb-4">
                <p id="reste" class="text-blue-600 font-semibold"></p>
            </div>

            <!-- MONTANT -->
            <div class="mb-6">
                <label class="block text-gray-600 mb-1">Montant</label>
                <input type="number" name="montant" step="0.01"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- ACTIONS -->
            <div class="flex justify-end gap-3">

                <!-- RETOUR -->
                <a href="{{ route('paiements.index') }}"
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    ↩ Annuler
                </a>

                <!-- PAYER -->
                <button type="submit"
                        class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                    💰 Payer
                </button>

            </div>

        </form>

    </div>

</div>

<!-- SCRIPT -->
<script>
document.getElementById('classe').addEventListener('change', function () {

    let classeId = this.value;

    fetch('/get-eleves/' + classeId)
    .then(res => res.json())
    .then(data => {

        let eleveSelect = document.getElementById('eleve');
        eleveSelect.innerHTML = '<option value="">Choisir un élève</option>';

        data.forEach(eleve => {
            eleveSelect.innerHTML += `<option value="${eleve.id}">${eleve.nom} ${eleve.prenom}</option>`;
        });
    });
});

document.getElementById('eleve').addEventListener('change', function () {

    let eleveId = this.value;

    fetch('/eleve/' + eleveId + '/reste')
    .then(res => res.text())
    .then(data => {
        document.getElementById('reste').innerText = "Reste à payer : " + data + " FCFA";
    });
});
</script>

</x-app-layout>