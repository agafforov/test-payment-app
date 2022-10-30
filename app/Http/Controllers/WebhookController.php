<?php

namespace App\Http\Controllers;

use App\Models\Payment;

/**
 * Class WebhookController
 */
class WebhookController extends Controller
{
    public function processPayment($gateway)
    {
        $params = request()->all();
        $payment = Payment::find($params['payment_id'] ?? $params['invoice'] ?? 0);
        if (empty($payment)) {
            abort(404, 'Payment was not found');
        }
        $payment->status = Payment::STATUS_MAP[$gateway][$params['status'] ?? ''] ?? Payment::STATUS_REJECTED;
        $payment->amount_paid = $params['amount_paid'] ?? 0;
        if (!$payment->save()) {
            abort(500, 'Unable to save payment status');
        }
        echo "Ok";
    }
}
