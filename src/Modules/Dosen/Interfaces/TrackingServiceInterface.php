<?php

namespace Modules\Dosen\Interfaces;

interface TrackingServiceInterface
{
    public function penelitianTracking($options);

    public function publikasiTracking($options);

    public function pengabdianTracking($options);
}
