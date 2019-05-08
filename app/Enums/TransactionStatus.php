<?php

namespace App\Enums;

use Konekt\Enum\Enum;

class TransactionStatus extends Enum
{
    const PENDING     = 'pending';
    const IN_PROGRESS = 'in progress';
    const COMPLETE    = 'complete';
    const FAILED      = 'failed';
}