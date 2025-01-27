<?php

namespace Modules\Dosen\Requests;

use App\Enums\Semester;
use Modules\CustomRequest;
use App\Models\LuaranKriteria;
use Illuminate\Validation\Rule;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class PenelitianRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tahun_akademik' => 'required|string|max:8',
            'semester' => [
                'required',
                Rule::enum(Semester::class),
            ],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'luaran_kriteria' => [
                'required',
                new ExistsByHash(LuaranKriteria::class),
            ],
            'bidang' => 'required|string',
            'anggota' => 'required|array',
            'anggota.*.nidn' => ['required'],
            'anggota.*.name' => ['required'],
            'anggota.*.name_with_title' => ['required'],
            'anggota.*.prodi' => ['required'],
            'anggota.*.phone_number' => ['required'],
            'anggota.*.email' => ['required'],
            'anggota.*.scholar_id' => ['required'],
            'anggota.*.scopus_id' => ['required'],
            'anggota.*.job_functional' => ['required'],
            'anggota.*.affiliate_campus' => ['required'],
        ];
    }
}
