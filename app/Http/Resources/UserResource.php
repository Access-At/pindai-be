<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userData = $this->getBaseUserData();

        return match ($userData['role']) {
            'kaprodi' => array_merge($userData, $this->getKaprodiData()),
            'dosen' => array_merge($userData, $this->getDosenData()),
            default => $userData
        };
    }

    private function getBaseUserData(): array
    {
        return [
            'id' => $this->hash,
            'name' => $this->name,
            'email' => $this->email,
            'nidn' => $this->nidn,
            'address' => $this->address,
            'role' => $this->roles->first()->name ?? false,
        ];
    }

    private function getKaprodiData(): array
    {
        return [
            'faculty' => $this->kaprodi->faculty->name,
        ];
    }

    private function getDosenData(): array
    {
        return [
            'name_title' => $this->dosen->name_with_title,
            'phone_number' => $this->dosen->phone_number,
            'scholar_id' => $this->dosen->scholar_id,
            'scopus_id' => $this->dosen->scopus_id,
            'job_functional' => $this->dosen->job_functional,
            'affiliate_campus' => $this->dosen->affiliate,
            'prodi' => $this->dosen->prodi->name,
        ];
    }
}
