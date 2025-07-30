<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('api')->user();
        Log::info('IsAdmin middleware check', [
            'user_id' => $user?->id,
            'email' => $user?->email,
            'role' => $user?->role,
        ]);
        if ($user && $user->role === 'admin') {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
