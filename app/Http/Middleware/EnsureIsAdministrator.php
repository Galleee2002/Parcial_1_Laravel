<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deja pasar al panel solo si el usuario autenticado es administrador.
 */
class EnsureIsAdministrator
{
    /**
     * Si el rol es administrador, sigue la petición.
     * Si no, vuelve a la home con el aviso de error.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === 'administrador') {
            return $next($request);
        }

        return redirect()
            ->route('home')
            ->with('feedback.message', 'No tenés permisos de administrador para acceder al panel.')
            ->with('feedback.type', 'danger');
    }
}
