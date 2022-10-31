<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class GatewayPaymentLimit
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $getaway
     * @param int $limit
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $getaway, int $limit = 0)
    {
        if (empty($limit)) {
            return $next($request);
        }

        $sum = Payment::where('gateway', $getaway)
            ->whereDate('updated_at', '=', date('Y-m-d'))
            ->sum('amount_paid');

        if ($sum >= $limit) {
            return response('Payment limit has exceeded for today', 429);
        }

        return $next($request);
    }
}
