<?php

namespace Modules\Dosen\Requests;

use App\Models\Luaran;
use Modules\CustomRequest;
use App\Models\LuaranKriteria;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class PublikasiRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'jenis_publikasi' => ['required', new ExistsByHash(Luaran::class)],
            'tanggal_publikasi' => 'required|date',
            'tahun' => 'required|string|max:4',
            'author' => 'required|string|max:255',
            'jurnal' => 'required|string|max:255',
            'link_publikasi' => 'required|string|max:255',
            'luaran_kriteria' => [
                'required',
                new ExistsByHash(LuaranKriteria::class),
            ],
        ];
    }
}
