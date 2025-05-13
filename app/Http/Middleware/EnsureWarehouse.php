<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureWarehouse
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->tokenCan('warehouse')) {
            return response()->json(['message' => 'Unauthorized (warehouse only)'], 403);
        }

        return $next($request);
    }
}

