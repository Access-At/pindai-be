<?php

namespace Modules\Dosen\Services;

use App\Helper\PaginateHelper;
use Modules\Dosen\Repositories\TrackingRepository;
use Modules\Dosen\Interfaces\TrackingServiceInterface;
use Modules\Dosen\Resources\Pagination\TrackingPaginationCollection;

class TrackingService implements TrackingServiceInterface
{
    public function penelitianTracking($options)
    {
        $data = PaginateHelper::paginate(
            TrackingRepository::penelitianTracking(),
            $options,
        );

        return new TrackingPaginationCollection($data);
    }

    public function publikasiTracking($options)
    {
        $data = PaginateHelper::paginate(
            TrackingRepository::publikasiTracking(),
            $options,
        );

        return new TrackingPaginationCollection($data);
    }

    public function pengabdianTracking($options)
    {
        $data = PaginateHelper::paginate(
            TrackingRepository::pengabdianTracking(),
            $options,
        );

        return new TrackingPaginationCollection($data);
    }
}
