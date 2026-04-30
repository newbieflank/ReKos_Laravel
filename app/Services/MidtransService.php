<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createCharge($orderData, $paymentType, $bankName = null)
    {
        $params = [
            'payment_type' => $paymentType,
            'transaction_details' => [
                'order_id' => $orderData['order_id'],
                'gross_amount' => (int) $orderData['gross_amount'],
            ],
            'customer_details' => [
                'first_name' => $orderData['customer']['name'],
                'email' => $orderData['customer']['email'],
            ],
        ];

        if ($paymentType === 'bank_transfer') {
            $params['bank_transfer'] = ['bank' => $bankName];
        }

        if ($paymentType === 'gopay') {
            $params['gopay'] = ['enable_callback' => true, 'callback_url' => url('/payment/finish')];
        }

        return CoreApi::charge($params);
    }

    public function getStatus($orderId)
    {
        return Transaction::status($orderId);
    }
}
