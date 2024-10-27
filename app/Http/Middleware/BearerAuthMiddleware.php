<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LogController;
use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BearerAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->logRequest($request);

        if( !str_contains( $request->path(), 'api/v1/' )  )
        {
                return $next($request);
        }

        $validToken = env('API_TOKEN');

        $providedToken = $request->bearerToken();

        if( !$providedToken ) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if( $providedToken != $validToken ) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

    private function logRequest(Request $request)
    {
        $log = new Log(
            [
                'url' => $request->url(),
                'method' => $request->method(),
                'request_body' => json_encode($request->all()),
                'dt_log' => now()
            ]
        );
        Log::create( $log->toArray() );
    }
}
