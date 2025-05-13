<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureHospital
{
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        if (!$request->user() || !$request->user()->tokenCan('hospital')) {
            return response()->json(['message' => 'Unauthorized - Hospital only'], 403);
        }

        return $next($request);
    }
}

