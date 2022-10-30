<?php

namespace App\Http\Controllers;

use App\Models\Payment;

/**
 * Class WebhookController
 */
class WebhookController extends Controller
{
    public function processPayment($merchantName)
    {
        $params = $this->sortParams(request()->all());
        $params = $this->clearParams($merchantName, $params);
        $joined = $this->concatParams($merchantName, $params);

        dd($params, $joined);
    }

    /**
     * @param $params
     * @return array
     */
    protected function sortParams($params): array
    {
        ksort($params);

        return $params;
    }

    /**
     * @param $merchantName
     * @param $params
     * @return mixed
     */
    protected function clearParams($merchantName, $params): mixed
    {
        if ($merchantName == Payment::MERCHANT_FIRST) {
            unset($params['sign']);
        }

        return $params;
    }

    /**
     * @param $merchantName
     * @param $params
     * @return string
     */
    protected function concatParams($merchantName, $params): string
    {
        if ($merchantName == Payment::MERCHANT_FIRST) {
            return join(':', $params);
        }

        return join('.', $params);
    }
}
