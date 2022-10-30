<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

use App\Models\Payment;

class FirstSignCheck
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
        $merchantName = $request->route()->parameter('merchantName');
        if (empty($merchantName) || $merchantName !== Payment::MERCHANT_FIRST) {
            return $next($request);
        }

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
