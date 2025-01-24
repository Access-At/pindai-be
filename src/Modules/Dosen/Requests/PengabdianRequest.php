<?php

namespace Modules\Dosen\Requests;

use App\Enums\Semester;
use Modules\CustomRequest;
use App\Models\JenisIndeksasi;
use App\Models\JenisPengabdian;
use Illuminate\Validation\Rule;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class PengabdianRequest extends CustomRequest
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
            'jenis_pengabdian' => ['required', new ExistsByHash(JenisPengabdian::class)],
            'jenis_indeksasi' => [
                'required',
                new ExistsByHash(JenisIndeksasi::class),
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
