<?php

namespace Modules\Dashboard\Interfaces;

interface DosenServiceInterface
{
    public function getNumberOfPenelitianByStatus();

    public function getNumberOfPengbdianByStatus();

    // TODO: Uncomment this when the API is ready
    // public function getNumberOfPublikasiByStatus();
}
