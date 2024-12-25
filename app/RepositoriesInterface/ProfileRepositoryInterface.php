<?php

namespace App\RepositoriesInterface;

interface ProfileRepositoryInterface
{
    public static function getProfile();
    public static function updateProfile($data);
    public static function changePassword($data);
}
