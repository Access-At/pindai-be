<?php

namespace Modules\Profile\Services;

use Modules\Profile\DataTransferObjects\ProfileDto;
use Modules\Profile\Interfaces\ProfileServiceInterface;
use Modules\Profile\Repositories\ProfileRepository;
use Modules\Profile\Resources\ProfileResource;

class ProfileService implements ProfileServiceInterface
{
    public function getProfile()
    {
        return new ProfileResource(ProfileRepository::getProfile());
    }

    public function updateProfile(ProfileDto $data)
    {
        return ProfileRepository::updateProfile($data);
    }
}
