<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    
        if (!auth()->check() || !auth()->user()->is_admin)
        {
          Log::warning('Intento de acceso no autorizado', [
            'user_id' => auth()->id(),
            'email' => auth()->user()->email ?? 'guest',
            'route' => $request->url(),
            'ip' => $request->ip(),
            'required_role' => 'admin'
        ]);
          abort(code:403);
        }
        
        return $next($request);
    }
}
