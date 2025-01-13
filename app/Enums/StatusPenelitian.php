<?php

namespace App\Enums;

enum StatusPenelitian: string
{
    case Draft = "Draft";
    case Pending = 'Menunggu';
    case Approval = 'Disetujui';
    case Reject = 'Ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'draft',
            self::Pending => 'pending',
            self::Approval => 'accepted',
            self::Reject => 'rejected'
        };
    }
}
