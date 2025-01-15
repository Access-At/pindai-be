<?php

namespace Modules\Dppm\Requests;

use App\Models\User;
use App\Models\Faculty;
use Modules\CustomRequest;
use Illuminate\Validation\Rule;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class KaprodiRequest extends CustomRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->kaprodi ? User::hashToId($this->kaprodi) : null),
            ],
            'nidn' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->kaprodi ? User::hashToId($this->kaprodi) : null),
            ],
            'address' => ['required', 'string', 'max:255'],
            'fakultas_id' => ['required', new ExistsByHash(Faculty::class)],
            'status' => ['required', 'boolean'],
        ];
    }
}
