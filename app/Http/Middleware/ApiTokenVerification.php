<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get token from header
        $token = $request->header('token');
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'status' => 401,
                'message' => 'Token not found'
            ], 401);
        }

        // Verify token
        $token = Token::where('token', $token)->first();
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'status' => 401,
                'message' => 'Invalid token'
            ], 401);
        }

        $token->hit_count += 1;
        $token->save();

        return $next($request);
    }
}
