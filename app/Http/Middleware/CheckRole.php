<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Verifica si el usuario está autenticado y tiene al menos uno de los roles proporcionados
        if (!Auth::check() || !$request->user()->hasAnyRole($roles)) {
            return response(view('errors.permission'), 403);
        }

        return $next($request);
    }
}
