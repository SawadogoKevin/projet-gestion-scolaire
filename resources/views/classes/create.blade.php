<x-app-layout>

    <div class="max-w-4xl mx-auto">

        <!-- HEADER -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            📚 Créer une classe
        </h1>

        <!-- FORM -->
        <div class="bg-white p-6 rounded-xl shadow-sm">

            <form method="POST" action="{{ route('classes.store') }}">
                @csrf

                <!-- NOM + FRAIS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    <div>
                        <label class="block text-gray-600 mb-1">Nom de la classe</label>
                        <input type="text" name="nom"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                               placeholder="Ex: 6ème A">
                    </div>

                    <div>
                        <label class="block text-gray-600 mb-1">Frais de scolarité</label>
                        <input type="number" name="frais"
                               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                               placeholder="Ex: 50000">
                    </div>

                </div>

                <!-- MATIERES -->
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">
                        📖 Matières
                    </h2>

                    <div id="matieres" class="space-y-3">

                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="matieres[0][nom]"
                                   class="border rounded-lg px-3 py-2"
                                   placeholder="Nom matière">

                            <input type="number" name="matieres[0][coefficient]"
                                   class="border rounded-lg px-3 py-2"
                                   placeholder="Coefficient">
                        </div>

                    </div>

                    <!-- AJOUT -->
                    <button type="button"
                            onclick="ajouterMatiere()"
                            class="mt-3 bg-gray-200 px-3 py-2 rounded-lg hover:bg-gray-300">
                        + Ajouter matière
                    </button>

                </div>
                <!-- ACTIONS -->
            <div class="flex justify-end gap-3">

<!-- RETOUR -->
<a href="{{ route('classes.index') }}"
   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
    ↩ Annuler
</a>

<!-- ENREGISTRER -->
<button type="submit"
        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
    💾 Mettre à jour
</button>

</div>

            </form>

        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        let index = 1;

        function ajouterMatiere() {

            let div = document.createElement('div');
            div.classList.add('grid', 'grid-cols-2', 'gap-3');

            div.innerHTML = `
                <input type="text" name="matieres[${index}][nom]"
                       class="border rounded-lg px-3 py-2"
                       placeholder="Nom matière">

                <input type="number" name="matieres[${index}][coefficient]"
                       class="border rounded-lg px-3 py-2"
                       placeholder="Coefficient">
            `;

            document.getElementById('matieres').appendChild(div);

            index++;
        }
    </script>

</x-app-layout>