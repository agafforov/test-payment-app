<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

/**
 * Class FirstGetawayAuth
 */
class FirstGetawayAuth
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
        $sign = $request->get('sign');
        $params = $request->except(['sign']);
        $merchantKey = config('first.merchant_key');
        ksort($params);
        $generatedSign = hash('sha256', join(":", $params) . $merchantKey);

        if ($sign === $generatedSign) {
            return $next($request);
        }

        return response('Corrupted Request', 400);
    }
}
