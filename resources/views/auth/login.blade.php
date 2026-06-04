<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200">

    <div class="w-full max-w-xl bg-white/70 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden border border-slate-200 p-10 m-4">

        <div class="mb-8 text-center">
            <div class="text-2xl mb-2">🎓</div>
            <h2 class="text-2xl font-bold text-slate-800">
                Connexion
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Bienvenue sur Neere SCHOOL, connectez-vous pour continuer
            </p>
        </div>

        <x-auth-session-status class="mb-4 text-emerald-600" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label class="text-sm font-semibold text-slate-600">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full mt-1.5 px-4 py-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-slate-700 focus:border-slate-700 transition shadow-sm text-slate-800"
                    required autofocus>

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600">Mot de passe</label>
                <input type="password" name="password"
                    class="w-full mt-1.5 px-4 py-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-slate-700 focus:border-slate-700 transition shadow-sm text-slate-800"
                    required>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember"
                        class="rounded border-slate-300 text-slate-800 focus:ring-slate-700">
                    Se souvenir
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-slate-600 hover:text-slate-900 hover:underline font-medium">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <button type="submit"
                class="w-full bg-slate-800 hover:bg-slate-900 text-white py-3 rounded-xl font-semibold transition duration-200 shadow-md hover:shadow-lg tracking-wide">
                Se connecter
            </button>
            <div class="text-center text-sm text-slate-600 mt-4">
            Pas encore de compte ?
            <a href="{{ url('/register') }}" class="text-slate-900 font-semibold hover:underline ml-1">
                S'inscrire
            </a>
            <a href="{{ route('password.request') }}">
    Mot de passe oublié ?
</a>
            </div>

        </form>

    </div>

</div>

</x-guest-layout>