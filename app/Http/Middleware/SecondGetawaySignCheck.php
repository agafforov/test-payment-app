<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

use App\Models\Payment;

class SecondGetawaySignCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $getaway = $request->route()->parameter('getaway');
        if ($getaway !== Payment::GATEWAY_SECOND) {
            return $next($request);
        }

        $sign = $request->header('Authorization');
        $params = $request->all();
        $appKey = config('second.app_key');
        ksort($params);
        $generatedSign = md5(join(".", $params) . $appKey);

        if ($sign === $generatedSign) {
            return $next($request);
        }

        return response('Corrupted Request', 400);
    }
}
