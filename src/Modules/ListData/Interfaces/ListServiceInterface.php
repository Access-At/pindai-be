<?php

namespace Modules\ListData\Interfaces;

interface ListServiceInterface
{
    public function getListFakultas();

    public function getListProdi(string $fakultas);

    public function getListDosen(array $options);

    public function getAuthorScholar(string $name);

    public function getAuthorProfileScholar(string $id);

    public function getListJenisIndeksasi();

    public function getListJenisPenelitian();

    public function getListJenisPengambdian();
}
