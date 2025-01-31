<?php

namespace Modules\Profile\Requests;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Faculty;
use Modules\CustomRequest;
use Illuminate\Validation\Rule;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class ProfileRequest extends CustomRequest
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
        $user = auth('api')->user();
        $role = $user->roles->first()->name;

        $baseRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'nidn' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ];

        if ($role === 'dosen') {
            $baseRules = array_merge($baseRules, [
                'prodi_id' => [
                    'required',
                    new ExistsByHash(Prodi::class),
                ],
                'name_with_title' => ['nullable', 'string', 'max:255'],
                'phone_number' => ['nullable', 'string', 'max:255'],
                'scholar_id' => ['nullable', 'string', 'max:255'],
                'scopus_id' => ['nullable', 'string', 'max:255'],
                'job_functional' => ['nullable', 'string', 'max:255'],
                'affiliate_campus' => ['nullable', 'string', 'max:255'],
            ]);
        }

        if ($role === 'kaprodi') {
            $baseRules = array_merge($baseRules, [
                'fakultas_id' => ['required', new ExistsByHash(Faculty::class)],
            ]);
        }

        return $baseRules;
    }
}
