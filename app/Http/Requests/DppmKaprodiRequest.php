<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Validation\Rule;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class DppmKaprodiRequest extends BaseFormRequest
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
