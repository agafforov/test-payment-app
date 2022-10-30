<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class WebhookController
 */
class WebhookController extends Controller
{
    public function processPayment($merchantName)
    {
        $payment = Payment::find($this->getPaymentId($merchantName));
        if (empty($payment)) {
            abort(404, 'Payment was not found');
        }

        $params = request()->all();
        $payment->status = Payment::STATUS_MAP[$merchantName][$params['status'] ?? ''] ?? Payment::STATUS_REJECTED;
        $payment->merchant_id = $this->getMerchantId($merchantName);
        $payment->amount_paid = $params['amount_paid'] ?? 0;
        $payment->save();
    }

    /**
     * @param $merchantName
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getPaymentId($merchantName): int
    {
        return match ($merchantName) {
            Payment::MERCHANT_FIRST => request()->get('payment_id'),
            Payment::MERCHANT_SECOND => request()->get('invoice'),
            default => 0,
        };
    }

    /**
     * @param $merchantName
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getMerchantId($merchantName): int
    {
        return match ($merchantName) {
            Payment::MERCHANT_FIRST => request()->get('merchant_id'),
            Payment::MERCHANT_SECOND => request()->get('project'),
            default => 0,
        };
    }
}
