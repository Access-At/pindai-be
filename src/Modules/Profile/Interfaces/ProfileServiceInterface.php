<?php

namespace Modules\Profile\Interfaces;

use Modules\Profile\DataTransferObjects\ProfileDto;

interface ProfileServiceInterface
{
    public function getProfile();

    public function updateProfile(ProfileDto $request);
}
