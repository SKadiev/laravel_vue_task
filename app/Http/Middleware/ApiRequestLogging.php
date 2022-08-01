<?php

namespace App\Http\Middleware;

use App\Models\LogEntry;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ApiRequestLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        return $next($request);
    }

    public function terminate(Request $request)
    {
        $logEntry = new LogEntry();
        $logEntry->ip = $request->ip();
        $logEntry->user_agent = $request->userAgent();
        $logEntry->url = $request->fullUrl();
        $logEntry->save();
    }
}
