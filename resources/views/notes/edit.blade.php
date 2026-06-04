<x-app-layout>

<div class="max-w-5xl mx-auto">



<h3 class="text-2xl font-bold text-gray-800 mb-6">
    📝 Modification groupée des notes
</h3>

<div class="bg-white p-6 rounded-xl shadow-sm">

    <form action="{{ route('notes.updateGrouped') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- CLASSE (FIXE) -->
        <input type="hidden" id="classe" value="{{ $classe->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

            <!-- MATIERE -->
            <div>
                <label class="block text-gray-600 mb-1">Matière</label>
                <select name="matiere_id" id="matiere" required
                        class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Choisir matière --</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- TRIMESTRE -->
            <div>
                <label class="block text-gray-600 mb-1">Trimestre</label>
                <select name="trimestre" id="trimestre" required
                        class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Choisir trimestre --</option>
                    <option value="1">1er Trimestre</option>
                    <option value="2">2ème Trimestre</option>
                    <option value="3">3ème Trimestre</option>
                </select>
            </div>

        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Nom & Prénom</th>
                        <th class="p-3 text-center">Note</th>
                    </tr>
                </thead>

                <tbody id="liste-eleves-edit">
                    <tr>
                        <td colspan="2" class="text-center p-4 text-gray-500">
                            Sélectionnez matière et trimestre
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ACTIONS -->
        <div class="flex justify-end gap-3">

            <a href="{{ route('notes.index') }}"
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                ↩ Annuler
            </a>

            <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                💾 Enregistrer
            </button>

        </div>

    </form>

</div>
```

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    let classeId = document.getElementById('classe').value;
    let matiereSelect = document.getElementById('matiere');
    let trimestreSelect = document.getElementById('trimestre');
    let tbody = document.getElementById('liste-eleves-edit');

    function chargerNotes() {

        let matiereId = matiereSelect.value;
        let trimestreId = trimestreSelect.value;

        if (classeId && matiereId && trimestreId) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center p-4 text-blue-500">
                        Chargement...
                    </td>
                </tr>
            `;

            fetch(`/get-notes-existantes/${classeId}/${matiereId}/${trimestreId}`)                .then(res => res.json())
                .then(data => {

                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="2" class="text-center p-4 text-gray-500">
                                    Aucun élève trouvé
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    data.forEach(item => {

                        let noteValeur = item.note_existante ?? '';

                        tbody.innerHTML += `
                            <tr class="border-t">
                                <td class="p-3">${item.nom} ${item.prenom}</td>
                                <td class="p-3 text-center">
                                    <input type="number"
                                           name="notes[${item.id}]"
                                           value="${noteValeur}"
                                           min="0"
                                           max="20"
                                           step="0.25"
                                           class="border rounded-lg px-2 py-1 w-24 text-center">
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(() => {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="2" class="text-center p-4 text-red-500">
                                Erreur lors du chargement
                            </td>
                        </tr>
                    `;
                });
        }
    }

    matiereSelect.addEventListener('change', chargerNotes);
    trimestreSelect.addEventListener('change', chargerNotes);

});
</script>

</x-app-layout>
