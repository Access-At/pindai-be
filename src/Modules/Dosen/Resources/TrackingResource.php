<?php

namespace Modules\Dosen\Resources;

use App\Enums\StatusPenelitian;
use Carbon\Carbon;
use Modules\CustomResource;
use Illuminate\Http\Request;

class TrackingResource extends CustomResource
{
    public function data(Request $request): array
    {
        return [
            'id' => $this->hash,
            'title' => $this->judul,
            'date' => Carbon::parse($this->created_at)->format('d M Y'),
            'status' => $this->determineStatus(),
            'steps' => $this->buildTrackingSteps()
        ];
    }

    private function determineStatus(): string
    {
        $allApproved = $this->status_kaprodi == StatusPenelitian::Approval &&
            $this->status_dppm == StatusPenelitian::Approval &&
            $this->status_keuangan == StatusPenelitian::Approval;

        $anyRejected = $this->status_kaprodi == StatusPenelitian::Reject ||
            $this->status_dppm == StatusPenelitian::Reject ||
            $this->status_keuangan == StatusPenelitian::Reject;

        return $allApproved ? StatusPenelitian::Approval : ($anyRejected ? 'canceled' : 'pending');
    }

    private function buildTrackingSteps(): array
    {
        $steps = [];

        $steps[] = $this->createStep(
            "Pengajuan {$this->category}",
            true,
            false,
            $this->created_at
        );

        $steps[] = $this->createStep(
            'Bagian Kepala Prodi Review',
            $this->status_kaprodi == StatusPenelitian::Approval,
            $this->status_kaprodi == StatusPenelitian::Reject,
            $this->status_kaprodi_date
        );

        if ($this->status_dppm_date !== null || $this->status_kaprodi === StatusPenelitian::Approval) {
            $steps[] = $this->createStep(
                'Bagian Direktorat Penelitian dan Pengabdian Pada Masyarakat Review',
                $this->status_dppm == StatusPenelitian::Approval,
                $this->status_dppm == StatusPenelitian::Reject,
                $this->status_dppm_date
            );
        }

        if ($this->status_keuangan_date !== null || $this->status_dppm === StatusPenelitian::Approval) {
            $steps[] = $this->createStep(
                'Bagian Keuangan Review',
                $this->status_keuangan == StatusPenelitian::Approval,
                $this->status_keuangan == StatusPenelitian::Reject,
                $this->status_keuangan_date
            );
        }

        return $steps;
    }

    private function createStep(string $name, bool $completed, bool $canceled, ?string $date): array
    {
        $carbonDate = $date ? Carbon::parse($date) : null;

        return [
            'name' => $name,
            'completed' => $completed,
            'canceled' => $canceled,
            'date' => $carbonDate ? $carbonDate->locale('id')->isoFormat('D MMMM Y') : null,
            'time' => $carbonDate ? $carbonDate->locale('id')->isoFormat('HH:mm') : null
        ];
    }
}
