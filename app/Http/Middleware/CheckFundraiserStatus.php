<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFundraiserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only apply to fundraisers
        if ($user && $user->role === 'fundraiser') {
            // Allowed routes for inactive fundraisers
            $allowedRoutes = [
                'fundraiser.index',           // Dashboard
                'fundraiser.citizen.index',   // Citizen form
                'fundraiser.citizen.store',   // Citizen form submit
                'fundraiser.citizen.update',  // Citizen form update
                'logout',                     // Sign out
            ];

            // If user is inactive and trying to access restricted routes
            if ($user->status === 'inactive' && !in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('fundraiser.citizen.index')
                    ->with('error', 'Please complete your KYC verification to access this feature.');
            }
        }

        return $next($request);
    }
}
