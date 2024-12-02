<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; // Utilisation correcte de la classe User


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Vérifie que l'utilisateur est connecté et a le rôle requis
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Accès refusé');
        }

        // Si le rôle est "admin", vérifie les limites de son agence
        if ($role === 'admin') {
            $user = Auth::user();

            // Vérifie si l'utilisateur essaie d'accéder ou de modifier une ressource d'une autre agence
            if ($request->route('id')) {
                $targetUser = User::find($request->route('id'));

                if ($targetUser && $targetUser->agence_id !== $user->agence_id) {
                    abort(403, 'Accès interdit à cette agence.');
                }
            }
        }

        return $next($request);
    }
}
