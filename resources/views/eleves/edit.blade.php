<x-app-layout>

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        ✏️ Modifier un élève
    </h1>

    <div class="bg-white p-6 rounded-xl shadow-sm">

        <form action="{{ route('eleves.update', $eleve->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- INFOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <!-- NOM -->
                <div>
                    <label class="block text-gray-600 mb-1">Nom</label>
                    <input type="text" name="nom"
                           value="{{ $eleve->nom }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- PRENOM -->
                <div>
                    <label class="block text-gray-600 mb-1">Prénom</label>
                    <input type="text" name="prenom"
                           value="{{ $eleve->prenom }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- DATE -->
                <div>
                    <label class="block text-gray-600 mb-1">Date de naissance</label>
                    <input type="date" name="date_naissance"
                           value="{{ $eleve->date_naissance }}"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <!-- CLASSE -->
                <div>
                    <label class="block text-gray-600 mb-1">Classe</label>
                    <select name="classe_id"
                            class="w-full border rounded-lg px-3 py-2">

                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}"
                                {{ $classe->id == $eleve->classe_id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <!-- PHOTO -->
            <div class="mb-6">

                <label class="block text-gray-600 mb-2">Photo actuelle</label>

                @if($eleve->photo)
                    <img src="{{ asset('storage/' . $eleve->photo) }}"
                         class="w-20 h-20 rounded-lg object-cover mb-3">
                @endif

                <input type="file" name="photo"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- ACTIONS -->
            <div class="flex justify-end gap-3">

                <!-- RETOUR -->
                <a href="{{ route('eleves.index') }}"
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

</x-app-layout>