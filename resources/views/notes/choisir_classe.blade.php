<x-app-layout>

<div class="max-w-3xl mx-auto">

    <!-- TITRE -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        📚 Choisir une classe
    </h2>

    <!-- LISTE -->
    <div class="bg-white rounded-xl shadow-sm p-4 space-y-3">

        @foreach($classes as $classe)

            <div class="flex justify-between items-center border-b pb-2">

                <!-- NOM -->
                <span class="text-gray-700 font-medium">
                    {{ $classe->nom }}
                </span>

                <!-- ACTION -->
                <a href="{{ route('bulletins.par.classe', $classe->id) }}"
                   class="bg-blue-500 text-white px-4 py-1 rounded-lg hover:bg-blue-600">
                    Voir bulletins
                </a>

            </div>

        @endforeach

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