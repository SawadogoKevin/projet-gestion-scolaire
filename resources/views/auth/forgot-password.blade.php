<x-guest-layout>


<!-- Message d'information -->
<div class="mb-4 text-sm text-gray-600">
    Mot de passe oublié ? Aucun problème.  
    Entrez simplement votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
</div>

<!-- Message de succès -->
<x-auth-session-status class="mb-4 text-green-600 font-medium" :status="session('status')" />

<!-- Formulaire -->
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email -->
    <div>
        <x-input-label for="email" :value="'Adresse Email'" />

        <x-text-input 
            id="email" 
            class="block mt-1 w-full" 
            type="email" 
            name="email" 
            :value="old('email')" 
            placeholder="exemple@email.com"
            required 
            autofocus 
        />

        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Bouton -->
    <div class="flex items-center justify-between mt-6">

        <!-- Retour login -->
        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
            Retour à la connexion
        </a>

        <!-- Bouton envoyer -->
        <x-primary-button>
            Envoyer le lien
        </x-primary-button>
    </div>

</form>


</x-guest-layout>
