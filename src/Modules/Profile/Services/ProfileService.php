<?php

namespace Modules\Profile\Services;

use Modules\Auth\Resources\AuthResource;
use Modules\Profile\Resources\ProfileResource;
use Modules\Profile\DataTransferObjects\ProfileDto;
use Modules\Profile\Repositories\ProfileRepository;
use Modules\Profile\Interfaces\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    public function getProfile()
    {
        return new ProfileResource(ProfileRepository::getProfile());
    }

    public function updateProfile(ProfileDto $data)
    {
        ProfileRepository::updateProfile($data);

        return new AuthResource(auth('api')->user());
    }
}
