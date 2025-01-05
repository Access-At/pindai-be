<?php

namespace Modules\Dashboard\Repositories;

use App\Models\Faculty;
use Illuminate\Support\Collection;

class DppmRepository
{
    public static function getNumberOfLecturersByFaculty(): Collection
    {
        return Faculty::withCount('dosen')
            ->orderBy('dosen_count', 'desc')
            ->take(8)
            ->get()
            ->map(function ($fakultas) {
                return [
                    'name' => $fakultas->name,
                    'dosen_count' => $fakultas->dosen_count,
                ];
            });
    }
}
