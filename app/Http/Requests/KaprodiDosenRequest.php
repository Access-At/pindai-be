<?php

namespace App\Http\Requests;

use App\Models\Prodi;
use Veelasky\LaravelHashId\Rules\ExistsByHash;
use App\Models\User;
use Illuminate\Validation\Rule;

class KaprodiDosenRequest extends BaseFormRequest
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
            "name" => ['required', 'string', 'max:255'],
            "email" => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->dosen ? User::hashToId($this->dosen) : null),
            ],
            "nidn" => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->dosen ? User::hashToId($this->dosen) : null),
            ],
            "address" => ['required', 'string', 'max:255'],
            'name_with_title' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'scholar_id' => ['required', 'string', 'max:255'],
            'scopus_id' => ['required', 'string', 'max:255'],
            'job_functional' => ['required', 'string', 'max:255'],
            'affiliate_campus' => ['required', 'string', 'max:255'],
            "prodi_id" => ['required', new ExistsByHash(Prodi::class)],
        ];
    }
}
