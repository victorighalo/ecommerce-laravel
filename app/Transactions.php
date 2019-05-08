<?php

namespace App;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Konekt\Enum\Eloquent\CastsEnums;

class Transactions extends Model
{
    use CastsEnums;

    protected $enums = [
        'status' => TransactionStatus::class
    ];
}
