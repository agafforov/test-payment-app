<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Payment
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $merchant_name
 * @property string $merchant_id
 * @property integer $status
 * @property integer $amount
 * @property integer $amount_paid
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Payment extends Model
{
    use HasFactory;

    const STATUS_CREATED = 0;
    const STATUS_REJECTED = 1;
    const STATUS_IN_PROGRESS = 10;
    const STATUS_EXPIRED = 90;
    const STATUS_PAID = 100;

    const MERCHANT_FIRST = 'first';
    const MERCHANT_SECOND = 'second';

    const STATUS_MAP = [
        self::MERCHANT_FIRST => [
            'new' => self::STATUS_CREATED,
            'rejected' => self::STATUS_REJECTED,
            'pending' => self::STATUS_IN_PROGRESS,
            'expired' => self::STATUS_EXPIRED,
            'completed' => self::STATUS_PAID,
        ],
        self::MERCHANT_SECOND => [
            'created' => self::STATUS_CREATED,
            'rejected' => self::STATUS_REJECTED,
            'inprogress' => self::STATUS_IN_PROGRESS,
            'expired' => self::STATUS_EXPIRED,
            'paid' => self::STATUS_PAID,
        ],
    ];
}
