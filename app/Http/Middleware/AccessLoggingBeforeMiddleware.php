<?php


namespace app\Http\Middleware;
use App\AccessLog;
use Closure;

class AccessLoggingBeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        AccessLog::create([
            "verb" => $request->method(),
            "path" => $request->path(),
        ]);
        return $next($request);
    }

}
