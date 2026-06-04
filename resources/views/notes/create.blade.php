<x-app-layout>

@if(session('error'))
    <div style="color: red; font-weight: bold; margin-bottom: 15px;">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-5xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        ➕ Ajouter des notes
    </h2>

    <div class="bg-white p-6 rounded-xl shadow-sm">

        <form action="{{ route('notes.store') }}" method="POST">
            @csrf 

            <!-- INFO CLASSE (AUTO) -->
            <div class="mb-6">
                <label class="block text-gray-600 mb-1">Classe</label>
                <input type="text"
                       value="{{ $classe->nom }}"
                       disabled
                       class="w-full border rounded-lg px-3 py-2 bg-gray-100">
            </div>

            <!-- MATIERE + TRIMESTRE -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <!-- MATIERE -->
                <div>
                    <label class="block text-gray-600 mb-1">Matière</label>
                    <select name="matiere_id" required
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choisir matière</option>

                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}">
                                {{ $matiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- TRIMESTRE -->
                <div>
                    <label class="block text-gray-600 mb-1">Trimestre</label>
                    <select name="trimestre" required
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Choisir trimestre</option>
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

                    <tbody>
                        @forelse($eleves as $eleve)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                </td>

                                <td class="p-3 text-center">
                                    <input type="number"
                                           name="notes[{{ $eleve->id }}]"
                                           min="0"
                                           max="20"
                                           step="0.25"
                                           required
                                           class="border rounded-lg px-2 py-1 w-24 text-center">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center p-4 text-gray-500">
                                    Aucun élève dans cette classe
                                </td>
                            </tr>
                        @endforelse
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

</div>

</x-app-layout>