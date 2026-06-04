<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, $role)
{
    // Vérifie si l'utilisateur est connecté
    if (!auth()->check()) {

        // Si non connecté → accès refusé
        abort(403, 'Accès refusé');

    }

    // Vérifie si le rôle correspond
    if (auth()->user()->role !== $role) {

        // Si mauvais rôle → accès refusé
        abort(403, 'Accès refusé');

    }

    // Si tout est bon → continuer la requête
    return $next($request);
}
}
