<?php

namespace App\Enums;

enum Semester: string
{
    case Genap = 'genap';
    case Ganjil = 'ganjil';

    public function label(): string
    {
        return match ($this) {
            self::Genap => 'Genap',
            self::Ganjil => 'Ganjil'
        };
    }
}
