<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NeereSCHOOL - Gestion Scolaire</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { 
            /* Utilisation des polices système modernes ultra-propres (Mac, Windows, Linux) qui ne demandent aucune connexion Internet */
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            letter-spacing: -0.01em;
        }
        /* Reproduction des formes géométriques grises en arrière-plan */
        .bg-geometric {
            background-color: #f4f6f8;
            background-image: 
                linear-gradient(135deg, rgba(225, 229, 235, 0.6) 0%, rgba(225, 229, 235, 0.6) 30%, transparent 30%),
                linear-gradient(225deg, rgba(210, 215, 223, 0.4) 0%, rgba(210, 215, 223, 0.4) 40%, transparent 40%);
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        /* Style des cartes sombres de l'image */
        .card-dark {
            background: linear-gradient(145deg, #2e3846, #1c232c);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>

<body class="bg-geometric text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <header class="w-full px-4 sm:px-8 py-4 sm:py-6 flex flex-col sm:flex-row justify-between items-center max-w-7xl mx-auto gap-4">
        <div class="flex items-center gap-3">
            <span class="text-2xl sm:text-3xl">🎓</span>
            <div class="text-xl sm:text-2xl font-semibold tracking-tight text-slate-800">
                Neere<span class="text-indigo-900 font-medium">SCHOOL</span>
            </div>
        </div>
        
        <div class="flex flex-wrap justify-center gap-2 sm:gap-3 text-xs sm:text-sm">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 sm:px-6 py-2 border border-slate-300 bg-white/80 hover:bg-white font-medium text-slate-700 rounded-xl transition duration-150 shadow-sm">
                        Tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 sm:px-6 py-2 border border-slate-300 bg-white/80 hover:bg-white font-medium text-slate-700 rounded-xl transition duration-150 shadow-sm">
                        Connexion
                    </a>
                    <a href="{{ url('/register') }}" class="px-4 sm:px-6 py-2 border border-slate-300 bg-white/80 hover:bg-white font-medium text-slate-700 rounded-xl transition duration-150 shadow-sm">
                        S'inscrire
                    </a>
                @endauth
            @endif
        </div>
    </header>

    <main class="flex-grow">
        <section class="max-w-5xl mx-auto px-4 sm:px-6 pt-8 sm:pt-12 pb-12 sm:pb-16 text-center space-y-4 sm:space-y-6">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-slate-800 tracking-tight leading-tight max-w-4xl mx-auto">
                <span class="text-slate-600 mr-1 sm:mr-2">⚡</span>Pilotez votre établissement scolaire avec <span class="text-indigo-900">Neere</span>
            </h1>
            
            <p class="text-base sm:text-lg text-slate-600 max-w-3xl mx-auto leading-relaxed font-normal">
                Une solution moderne et intuitive pour centraliser le suivi des élèves, l'<strong>encaissement des frais de scolarité</strong>, la saisie des <strong>notes</strong> et la génération des bulletins.
            </p>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 pb-16 sm:pb-24">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 mb-6 sm:mb-8 tracking-tight">
                Fonctionnalités Clés
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="card-dark rounded-2xl p-6 shadow-xl transition duration-200 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-white/10 text-white rounded-xl flex items-center justify-center text-xl mb-6 border border-white/10">
                        🏫
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-3">Classes & Élèves</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Structurez votre établissement par niveau et gérez les inscriptions.
                    </p>
                </div>

                <div class="card-dark rounded-2xl p-6 shadow-xl transition duration-200 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-xl flex items-center justify-center text-xl mb-6 border border-emerald-500/20">
                        📊
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-3">Suivi des Notes</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Saisie groupée, calcul automatique des moyennes et classements.
                    </p>
                </div>

                <div class="card-dark rounded-2xl p-6 shadow-xl transition duration-200 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-indigo-500/20 text-indigo-400 rounded-xl flex items-center justify-center text-xl mb-6 border border-indigo-500/20">
                        💰
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-3">Gestion Financière</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Suivi des paiements, frais de scolarité, et répartition financière.
                    </p>
                </div>

                <div class="card-dark rounded-2xl p-6 shadow-xl transition duration-200 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-white/10 text-white rounded-xl flex items-center justify-center text-xl mb-6 border border-white/10">
                        🏆
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-3">Bulletins & PDF</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Générez et téléchargez des bulletins détaillés au format PDF.
                    </p>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="w-full max-w-7xl mx-auto px-4 sm:px-8 py-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center text-sm text-slate-400 gap-3 text-center sm:text-left">
        <p>&copy; {{ date('Y') }} NeereSCHOOL. Tous droits réservés.</p>
        <span class="text-xs bg-slate-200/60 text-slate-500 px-3 py-1 rounded-full font-medium w-fit">Propulsé par Neere</span>
    </footer>

</body>
</html>