<?php

namespace Modules\Profile\Services;

use App\Helper\EncryptData;
use App\Helper\ResponseApi;
use Modules\Auth\Resources\AuthResource;
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
        ProfileRepository::updateProfile($data);
        return new AuthResource(auth('api')->user());
    }
}
