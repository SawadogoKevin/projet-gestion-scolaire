<x-app-layout>

    <div class="max-w-5xl mx-auto">

        <!-- MESSAGE SUCCÈS -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- ERREUR -->
        @if($errors->has('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                ❌ {{ $errors->first('error') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            ✏️ Modifier Classe
        </h1>

        <div class="bg-white p-6 rounded-xl shadow-sm">

            <form method="POST" action="{{ route('classes.update', $classe->id) }}">
                @csrf
                @method('PUT')

                <!-- NOM + FRAIS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    <div>
                        <label class="block text-gray-600 mb-1">Nom</label>
                        <input type="text" name="nom"
                               value="{{ $classe->nom }}"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-gray-600 mb-1">Frais</label>
                        <input type="number" name="frais"
                               value="{{ $classe->frais_scolarite }}"
                               class="w-full border rounded-lg px-3 py-2">
                    </div>

                </div>

                <!-- MATIERES EXISTANTES -->
                <h2 class="text-lg font-semibold mb-3">📖 Matières existantes</h2>

                <div class="space-y-3 mb-6">

                    @foreach($classe->matieres as $matiere)
                        <div class="grid grid-cols-3 gap-3 items-center bg-gray-50 p-3 rounded-lg">

                            <input type="text"
                                   name="matieres_existantes[{{ $matiere->id }}][nom]"
                                   value="{{ $matiere->nom }}"
                                   class="border rounded-lg px-3 py-2">

                            <input type="number"
                                   name="matieres_existantes[{{ $matiere->id }}][coefficient]"
                                   value="{{ $matiere->coefficient }}"
                                   class="border rounded-lg px-3 py-2">

                            <label class="flex items-center gap-2 text-red-600">
                                <input type="checkbox"
                                       name="matieres_existantes[{{ $matiere->id }}][delete]">
                                Supprimer
                            </label>

                        </div>
                    @endforeach

                </div>

                <!-- NOUVELLES MATIERES -->
                <h2 class="text-lg font-semibold mb-3">➕ Ajouter matières</h2>

                <div id="new-matieres" class="space-y-3 mb-4">

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="matieres_nouvelles[0][nom]"
                               class="border rounded-lg px-3 py-2"
                               placeholder="Nom matière">

                        <input type="number" name="matieres_nouvelles[0][coefficient]"
                               class="border rounded-lg px-3 py-2"
                               placeholder="Coefficient">
                    </div>

                </div>

                <button type="button"
                        onclick="addMatiere()"
                        class="bg-gray-200 px-3 py-2 rounded-lg hover:bg-gray-300 mb-6">
                    + Ajouter matière
                </button>

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
        💾 Enregistrer
    </button>

</div>

            </form>

        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        function addMatiere() {

            let index = document.querySelectorAll('#new-matieres div').length;

            let div = document.createElement('div');
            div.classList.add('grid', 'grid-cols-2', 'gap-3');

            div.innerHTML = `
                <input type="text" name="matieres_nouvelles[${index}][nom]"
                       class="border rounded-lg px-3 py-2"
                       placeholder="Nom matière">

                <input type="number" name="matieres_nouvelles[${index}][coefficient]"
                       class="border rounded-lg px-3 py-2"
                       placeholder="Coefficient">
            `;

            document.getElementById('new-matieres').appendChild(div);
        }
    </script>

</x-app-layout>