<?php

namespace App\Helper;

use Exception;

class SecureCommunication
{
    private static string $encryptionKey = '';
    private static string $cipher = 'aes-256-gcm';

    public function __construct()
    {
        self::$encryptionKey = env('SECURE_COMMUNICATION_KEY');

        if (strlen(self::$encryptionKey) !== 32) {
            throw new Exception('Encryption key must be exactly 32 characters.');
        }
    }

    public static function encrypt(string $data): string
    {
        if (empty(self::$encryptionKey)) {
            new self();
        }

        $iv = random_bytes(12); // Panjang IV untuk AES-GCM

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

        // Gabungkan IV, tag, dan cipher untuk transportasi
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

        $ivLength = 12; // Panjang IV untuk AES-GCM
        $tagLength = 16; // Panjang tag autentikasi

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
