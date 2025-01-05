<?php

namespace Modules\Kaprodi\Requests;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Validation\Rule;
use Modules\CustomRequest;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class DosenRequest extends CustomRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->dosen ? User::hashToId($this->dosen) : null),
            ],
            'nidn' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->dosen ? User::hashToId($this->dosen) : null),
            ],
            'prodi_id' => ['required', new ExistsByHash(Prodi::class)],
            'address' => ['nullable', 'string', 'max:255'],
            'name_with_title' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'scholar_id' => ['sometimes', 'string', 'max:255'],
            'scopus_id' => ['sometimes', 'string', 'max:255'],
            'job_functional' => ['nullable', 'string', 'max:255'],
            'affiliate_campus' => ['nullable', 'string', 'max:255'],
        ];
    }
}
