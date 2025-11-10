<?php

namespace App\Enum;

enum TransactionType : string
{
    case DEPOSIT      = 'deposit';
    case WITHDRAW     = 'withdraw';
    case TRANSFER_IN  = 'transfer_in';
    case TRANSFER_OUT = 'transfer_out';

    public function label(): string
    {
        return match ($this) {
            self::DEPOSIT      => 'Deposit',
            self::WITHDRAW     => 'Withdraw',
            self::TRANSFER_IN  => 'Transfer in',
            self::TRANSFER_OUT => 'Transfer out',
        };
    }
}
