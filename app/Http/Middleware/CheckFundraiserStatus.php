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
            $allowedRoutesInactive = [
                'fundraiser.index',           // Dashboard
                'fundraiser.citizen.index',   // Citizen form
                'fundraiser.citizen.store',   // Citizen form submit
                'fundraiser.citizen.update',  // Citizen form update
                'logout',                     // Sign out
            ];

            // Allowed routes for suspended fundraisers
            $allowedRoutesSuspended = [
                'fundraiser.index',           // Dashboard
                'fundraiser.suspended.index', // Suspended page
                'fundraiser.inbox.index',     // Inbox list
                'fundraiser.inbox.show',      // Inbox detail
                'fundraiser.chats.index',     // Chat with admin
                'fundraiser.chats.store',     // Send chat message
                'logout',                     // Sign out
            ];

            // If user is inactive and trying to access restricted routes
            if ($user->status === 'inactive' && !in_array($request->route()->getName(), $allowedRoutesInactive)) {
                return redirect()->route('fundraiser.citizen.index')
                    ->with('error', 'Please complete your KYC verification to access this feature.');
            }

            // If user is suspended and trying to access restricted routes
            if ($user->status === 'suspended' && !in_array($request->route()->getName(), $allowedRoutesSuspended)) {
                return redirect()->route('fundraiser.suspended.index')
                    ->with('error', 'Your account is currently suspended. Please contact admin for more information.');
            }
        }

        return $next($request);
    }
}
