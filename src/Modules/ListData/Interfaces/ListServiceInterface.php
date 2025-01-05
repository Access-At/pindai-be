<?php

namespace Modules\ListData\Interfaces;

interface ListServiceInterface
{
    public function getListFakultas();
    public function getListProdi(string $fakultas);
    public function getListDosen(string $name);
    public function getAuthorScholar(string $name);
    public function getAuthorProfileScholar(string $id);
}
