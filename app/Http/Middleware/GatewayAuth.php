<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

/**
 * Class GatewayAuth
 */
class GatewayAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $getaway
     * @return Response|RedirectResponse
     */
    public function handle(
        Request $request,
        Closure $next,
        string  $getaway
    )
    {
        $configs = config($getaway);
        $except = $configs['except'] ?? [];
        $hashAlgo = $configs['hash_algo'] ?? 'sha256';
        $separator = $configs['separator'] ?? ':';
        $merchantKey = $configs['merchant_key'] ?? 'sign';
        $signatureName = $configs['signature_name'] ?? 'sign';
        $signatureSource = $configs['signature_source'] ?? 'body';

        $sign = $request->get($signatureName);
        if ($signatureSource == 'header') {
            $sign = $request->header($signatureName);
        }
        $params = $request->except($except);
        ksort($params);
        $stringToHash = join($separator, $params) . $merchantKey;
        $generatedSign = "";

        switch ($hashAlgo) {
            case 'md5':
                $generatedSign = md5($stringToHash);
                break;
            case 'sha256':
                $generatedSign = hash('sha256', $stringToHash);
                break;
        }

        if ($sign === $generatedSign) {
            return $next($request);
        }

        return response('Corrupted Request', 400);
    }
}
