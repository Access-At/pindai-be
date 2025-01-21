<?php

namespace App\Enums;

enum StatusPenelitian: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Approval = 'accepted';
    case Reject = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'draft',
            self::Pending => 'pending',
            self::Approval => 'accepted',
            self::Reject => 'rejected'
        };
    }

    public function message(): string
    {
        return match ($this) {
            self::Draft => 'sedang dalam penyusunan',
            self::Pending => 'menunggu konfirmasi',
            self::Approval => 'telah disetujui',
            self::Reject => 'telah ditolak'
        };
    }
}
