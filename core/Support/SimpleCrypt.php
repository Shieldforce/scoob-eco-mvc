<?php

namespace ScoobEcoCore\Support;

use ScoobEco\Exception\SessionException;
use ScoobEcoCore\Boot\Session;

class SimpleCrypt
{
    private static string $key;
    private static string $cipher = "AES-256-CBC";

    public static function encrypt(string $plaintext): string
    {
        self::$key = Session::key();

        if (!self::$key) {
            throw new SessionException(
                "ScoobEco Session key not set!"
            );
        }

        $iv        = random_bytes(openssl_cipher_iv_length(self::$cipher));
        $encrypted = openssl_encrypt($plaintext, self::$cipher, self::$key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public static function decrypt(string $ciphertext): string
    {
        self::$key = Session::key();

        if (!self::$key) {
            throw new SessionException(
                "ScoobEco Session key not set!"
            );
        }

        $data      = base64_decode($ciphertext);
        $ivLength  = openssl_cipher_iv_length(self::$cipher);
        $iv        = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);

        return openssl_decrypt($encrypted, self::$cipher, self::$key, 0, $iv);
    }

}