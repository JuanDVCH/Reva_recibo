<?php
// app/Http/Middleware/AdministradorMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministradorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario tiene el rol de "Administrador"
        if ($request->user() && $request->user()->hasRole('Administrador')) {
            return $next($request);
        }

        // Si no tiene el rol, mostrar la vista personalizada de error 403
        return response(view('errors.permission'), 403);
    }
}
