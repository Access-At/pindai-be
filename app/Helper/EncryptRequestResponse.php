<?php

namespace App\Helper;

use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;

class EncryptRequestResponse
{
    private const ALGORITHM = 'aes-256-cbc';

    private const BASE64_PREFIX = 'base64:';

    public static function make(): Encrypter
    {
        return new Encrypter(self::getDecryptedKey(), self::ALGORITHM);
    }

    private static function getDecryptedKey(): string
    {
        $key = env('SECURE_REQUEST_KEY');

        return Str::startsWith($key, self::BASE64_PREFIX)
            ? base64_decode(Str::after($key, self::BASE64_PREFIX), true)
            : $key;
    }
}
