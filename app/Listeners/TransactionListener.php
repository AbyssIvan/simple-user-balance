<?php

namespace App\Listeners;

use App\Enum\TransactionType;
use App\Events\TransactionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(TransactionEvent $event): void
    {
        /*
         * notifications (sms/email)
         */
        switch ($event->transaction->type) {
            case TransactionType::DEPOSIT:
                break;
            case TransactionType::WITHDRAW:
                break;
            case TransactionType::TRANSFER_OUT:
                break;
            case TransactionType::TRANSFER_IN:
                break;
            default:
                break;
        }
    }
}
