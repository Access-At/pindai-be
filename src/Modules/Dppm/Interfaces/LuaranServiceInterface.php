<?php

namespace Modules\Dppm\Interfaces;

use Modules\Dppm\DataTransferObjects\LuaranDto;

interface LuaranServiceInterface
{
    public function getAllLuaran(array $options);

    public function getLuaranById(string $id);

    public function insertLuaran(LuaranDto $requst);

    public function updateLuaran(string $faculty, LuaranDto $request);

    public function deleteLuaran(string $faculty);
}
