<?php

namespace App\Enums;

enum Role: string
{
    case Dppm = 'dppm';
    case Kaprodi = 'kaprodi';
    case Dosen = 'dosen';
    case Keuangan = 'keuangan';
}
