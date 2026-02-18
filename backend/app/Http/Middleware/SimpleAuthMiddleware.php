<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SimpleAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'message' => 'Token requis'
            ], 401);
        }

        // Decode simple token (email:id)
        $decoded = base64_decode($token);
        if (!$decoded || !str_contains($decoded, ':')) {
            return response()->json([
                'message' => 'Token invalide'
            ], 401);
        }

        [$email, $id] = explode(':', $decoded);
        
        // Find user
        $user = \App\Models\User::where('email', $email)->where('id', $id)->first();
        
        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non trouvé'
            ], 401);
        }

        // Add user to request for later use
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
