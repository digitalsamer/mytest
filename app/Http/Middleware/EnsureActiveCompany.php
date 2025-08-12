<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user->active_company_id || ! $user->activeCompany) {
            return response()->json([
                'message' => 'No active company set.'
            ], 400);
        }

        // Set active company globally
        app()->instance('currentCompany', $user->activeCompany);

        return $next($request);
    }
}
