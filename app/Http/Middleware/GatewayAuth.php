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

        $signature = $request->get($signatureName);
        if ($signatureSource == 'header') {
            $signature = $request->header($signatureName);
        }
        $params = $request->except($except);
        ksort($params);
        $stringToHash = join($separator, $params) . $merchantKey;
        $generatedSignature = "";

        switch ($hashAlgo) {
            case 'md5':
                $generatedSignature = md5($stringToHash);
                break;
            case 'sha256':
                $generatedSignature = hash('sha256', $stringToHash);
                break;
        }

        if ($signature === $generatedSignature) {
            return $next($request);
        }

        return response('Corrupted Request', 400);
    }
}
