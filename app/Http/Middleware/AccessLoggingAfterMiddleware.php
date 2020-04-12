<?php


namespace app\Http\Middleware;

use App\AccessLog;
use Closure;

class AccessLoggingAfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $log = AccessLog::latest()->first();
        $log->update(["status" => $response->status()]);

        return $response;
    }
}
