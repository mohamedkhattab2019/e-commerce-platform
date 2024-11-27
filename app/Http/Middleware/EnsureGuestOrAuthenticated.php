<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureGuestOrAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('sanctum')->user();        
        $guestToken = $request->header('Guest-Token') ?? $request->query('guest_token'); // Guest token
        
        // Reject requests if neither user nor guest token is available
        if (!$user && !$guestToken) {
            return response()->json(['error' => 'Unauthorized: Please log in or provide a guest token'], 401);
        }
        if ($user) {
            $request->merge(['user_id' => $user->id]);
        }
        // Attach the guest token to the request
        if ($guestToken) {
            $request->merge(['guest_token' => $guestToken]);
        }

        return $next($request);
    }
}
