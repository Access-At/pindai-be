<?php

namespace Modules\Auth\Exceptions;

use Modules\CustomException;

class AuthException extends CustomException
{
    public static function userNotFound(): self
    {
        return new self('Pengguna tidak terdaftar.', 404, 'Login gagal');
    }

    public static function dosenNotApproved(): self
    {
        return new self('Akun anda belum di approval. tolong hubungi Kaprodi masing-masing', 401, 'Login gagal');
    }

    public static function dosenNotActive(): self
    {
        return new self('Akun anda telah dinonaktifkan. tolong hubungi Kaprodi masing-masing', 401, 'Login gagal');
    }

    public static function kaprodiNotActive(): self
    {
        return new self('Akun anda telah dinonaktifkan. tolong hubungi DPPM masing-masing', 401, 'Login gagal');
    }

    public static function unauthorized(): self
    {
        return new self('Email / Password anda salah!', 401, 'Login gagal');
    }

    public static function userNotLogined(): self
    {
        return new self('Anda belum login.', 401, 'Login gagal');
    }
}
