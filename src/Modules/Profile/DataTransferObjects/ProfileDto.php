<?php

namespace Modules\Profile\DataTransferObjects;

use Modules\Profile\Requests\ProfileRequest;

// $baseRules = [
//     'name' => 'required|string|max:255',
//     'email' => 'required|email|unique:users,email,' . $user->id,
//     'address' => 'nullable|string|max:255',
//     'nidn' => [
//         'required',
//         'string',
//         'max:255',
//         Rule::unique(User::class)->ignore($user->id),
//     ],
// ];

// if ($role === 'dosen') {
//     $baseRules = array_merge($baseRules, [
//         'prodi_id' => [
//             'required',
//             new ExistsByHash(Prodi::class),
//         ],
//         'name_with_title' => ['nullable', 'string', 'max:255'],
//         'phone_number' => ['nullable', 'string', 'max:255'],
//         'scholar_id' => ['nullable', 'string', 'max:255'],
//         'scopus_id' => ['nullable', 'string', 'max:255'],
//         'job_functional' => ['nullable', 'string', 'max:255'],
//         'affiliate_campus' => ['nullable', 'string', 'max:255'],
//     ]);
// }

// if ($role === 'kaprodi') {
//     $baseRules = array_merge($baseRules, [
//         'fakultas_id' => ['required', new ExistsByHash(Faculty::class)],
//         'status' => 'required|boolean',
//     ]);
// }

// return $baseRules;

class ProfileDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $nidn,
        public ?string $address,
        public ?string $prodi_id,
        public ?string $fakultas_id,
        public ?string $name_with_title,
        public ?string $phone_number,
        public ?string $scholar_id,
        public ?string $scopus_id,
        public ?string $job_functional,
        public ?string $affiliate_campus,
        public ?string $password,
    ) {}

    public static function fromRequest(ProfileRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('nidn'),
            $request->validated('address'),
            $request->validated('prodi_id'),
            $request->validated('fakultas_id'),
            $request->validated('name_with_title'),
            $request->validated('phone_number'),
            $request->validated('scholar_id'),
            $request->validated('scopus_id'),
            $request->validated('job_functional'),
            $request->validated('affiliate_campus'),
            $request->password
        );
    }
}
