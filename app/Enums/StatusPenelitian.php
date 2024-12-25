<?php

namespace App\Enums;

enum StatusPenelitian: string
{
    case Approval = 'Disetujui';
    case Pending = 'Menunggu';
    case Reject = 'Ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Approval => 'Disetujui',
            self::Pending => 'Menunggu Persetujuan',
            self::Reject => 'Ditolak'
        };
    }
}
