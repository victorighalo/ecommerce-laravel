<?php

namespace App\Enums;

use Konekt\Enum\Enum;

class TransactionStatus extends Enum
{
    const PENDING     = 'pending';
    const IN_PROGRESS = 'in_progress';
    const COMPLETE    = 'complete';
    const FAILED      = 'failed';
    const PAY_DELIVERY      = 'pay_on_delivery';
}
