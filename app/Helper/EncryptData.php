<?php

namespace App\Helper;

use Exception;

class EncryptData
{
    private static string $encryptionKey = '';
    private static string $cipher = 'aes-256-gcm';

    public function __construct()
    {
        self::$encryptionKey = env('SECURE_DATA_KEY');

        if (strlen(self::$encryptionKey) !== 32) {
            throw new Exception('Encryption key must be exactly 32 characters.');
        }
    }

    public static function encrypt(string $data): string
    {
        if (empty(self::$encryptionKey)) {
            new self();
        }

        $iv = random_bytes(12);

        $cipher = openssl_encrypt(
            $data,
            self::$cipher,
            self::$encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($cipher === false) {
            throw new Exception('Encryption failed.');
        }

        return base64_encode($iv . $tag . $cipher);
    }

    public static function decrypt(string $data): string
    {
        if (empty(self::$encryptionKey)) {
            new self();
        }

        $decoded = base64_decode($data);

        if ($decoded === false) {
            throw new Exception('Decryption failed: invalid base64 encoding.');
        }

        $ivLength = 12;
        $tagLength = 16;

        if (strlen($decoded) < ($ivLength + $tagLength)) {
            throw new Exception('Decryption failed: data is too short.');
        }

        $iv = substr($decoded, 0, $ivLength);
        $tag = substr($decoded, $ivLength, $tagLength);
        $cipher = substr($decoded, $ivLength + $tagLength);

        $plainText = openssl_decrypt(
            $cipher,
            self::$cipher,
            self::$encryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($plainText === false) {
            throw new Exception('Decryption failed.');
        }

        return $plainText;
    }
}
