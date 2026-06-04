<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neere School</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@heroicons/mesh-with-dependencies@1.0.1/dist/heroicons.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 font-sans antialiased" x-data="{ mobileMenuOpen: false }">

<div class="flex h-screen overflow-hidden relative">

    <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="w-64 bg-slate-900 text-slate-400 flex flex-col border-r border-slate-800 fixed inset-y-0 left-0 z-50 transform lg:static lg:translate-x-0 transition duration-300 ease-in-out">

        <div class="h-16 flex items-center justify-between px-6 text-white font-bold text-lg tracking-wider border-b border-slate-800 gap-2">
            <div class="flex items-center gap-2">
                <span class="bg-indigo-600 text-white p-1.5 rounded-lg text-xs">⚡</span>
                <span>Neere<span class="text-indigo-500 font-light text-sm">SCHOOL</span></span>
            </div>
            <button @click="mobileMenuOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200
               {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-slate-800 hover:text-slate-200' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1/1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('eleves.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200
               {{ request()->routeIs('eleves.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-slate-800 hover:text-slate-200' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                Élèves
            </a>

            @if(auth()->user()->role !== 'enseignant')
            <a href="{{ route('classes.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200
               {{ request()->routeIs('classes.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-slate-800 hover:text-slate-200' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                Classes
            </a>
            @endif

            @if(auth()->user()->role !== 'gestionnaire')
            <a href="{{ route('notes.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200
               {{ request()->routeIs('notes.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-slate-800 hover:text-slate-200' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Notes
            </a>
            @endif

            @if(auth()->user()->role !== 'enseignant')
            <a href="{{ route('paiements.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200
               {{ request()->routeIs('paiements.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'hover:bg-slate-800 hover:text-slate-200' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Paiements
            </a>
            @endif

            @if(auth()->user()->role === 'gestionnaire')
            <div class="pt-4 border-t border-slate-800 mt-4">
                <a href="{{ route('affectations.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Affecter un enseignant
                </a>
            </div>
            @endif

            @if(auth()->user()->role === 'gestionnaire')
            <div class="pt-4 border-t border-slate-800 mt-4">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Admin
                </a>
            </div>
            @endif

        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-950/40 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-sm uppercase">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-200 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 truncate">Connecté</p>
            </div>
        </div>

    </aside>

    <div @click="mobileMenuOpen = false" x-show="mobileMenuOpen" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition></div>

    <div class="flex-1 flex flex-col min-w-0">

        <header class="h-16 bg-white flex items-center justify-between px-4 lg:px-8 border-b border-slate-200/80">

            <div class="flex items-center gap-4">
                <button @click="mobileMenuOpen = true" class="text-slate-600 lg:hidden p-1 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <h1 class="text-base lg:text-lg font-semibold text-slate-800 truncate">
                    Tableau de bord
                </h1>
            </div>

            <div class="flex items-center gap-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center gap-2 text-sm text-slate-500 hover:text-rose-600 font-medium transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="hidden sm:inline">Déconnexion</span>
                    </button>
                </form>
            </div>

        </header>

        <main class="p-4 lg:p-8 overflow-y-auto bg-slate-50/50 flex-1">
            {{ $slot }}
        </main>

    </div>

</div>

@if(session('success'))
    <div id="toast-success"
         class="fixed top-5 right-5 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg opacity-0 translate-y-2 transition-all duration-500">
        {{ session('success') }}
    </div>

    <script>
        let toast = document.getElementById('toast-success');
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-2');
            toast.classList.add('opacity-100', 'translate-y-0');
        }, 100);

        setTimeout(() => {
            toast.classList.remove('opacity-100');
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    </script>
@endif

</body>
</html>