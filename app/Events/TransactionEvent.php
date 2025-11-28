<?php

namespace App\Events;

use App\Models\UserTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly UserTransaction $transaction)
    {
    }
}
