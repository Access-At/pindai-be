<?php

namespace Modules\Dashboard\Repositories;

use App\Enums\StatusPenelitian;
use App\Models\Faculty;
use App\Models\Penelitian;
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

    public static function getNumberOfPenelitianByStatus(): Collection
    {
        return Penelitian::whereIn('status_kaprodi', [StatusPenelitian::Approval, StatusPenelitian::Reject])
            ->selectRaw('status_kaprodi as status, COUNT(*) as count')
            ->groupBy('status_kaprodi')
            ->get();
    }

    public static function getNewsPenelitian(): Collection
    {
        return Penelitian::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
}
