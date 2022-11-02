<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

/**
 * Class WebhookController
 */
class WebhookController extends Controller
{
    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function first(): void
    {
        $this->updatePayment(request()->get('payment_id', 0), Payment::GATEWAY_FIRST);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function second(): void
    {
        $this->updatePayment(request()->get('invoice', 0), Payment::GATEWAY_SECOND);
    }

    /**
     * @param int $id
     * @param string $getaway
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function updatePayment(int $id, string $getaway): void
    {
        $params = request()->all();
        $payment = Payment::find($id);
        if (empty($payment)) {
            abort(404, 'Payment was not found');
        }

        if ($payment->isHandled()) {
            abort(400, 'The payment has been already handled.');
        }

        $payment->status = Payment::STATUS_MAP[$getaway][$params['status'] ?? ''] ?? Payment::STATUS_IN_PROGRESS;
        $payment->amount_paid = $params['amount_paid'] ?? 0;
        if (!$payment->save()) {
            abort(500, 'Unable to save payment status');
        }
        echo "Ok";
    }
}
