<?php

namespace App\Services;

use App\Repositories\ProfileRepository;

class ProfileService
{
    public static function getProfile()
    {
        return ProfileRepository::getProfile();
    }

    public static function updateProfile($data)
    {
        return ProfileRepository::updateProfile($data);
    }

    public static function changePassword()
    {
        //
    }
}
