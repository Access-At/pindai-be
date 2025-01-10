<?php

namespace App\Enums;

enum StatusPenelitian: string
{
    case Pending = 'Menunggu';
    case Approval = 'Disetujui';
    case Reject = 'Ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Waiting for Approval',
            self::Approval => 'Approved',
            self::Reject => 'Rejected'
        };
    }
}
