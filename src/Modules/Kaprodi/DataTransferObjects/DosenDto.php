<?php

namespace Modules\Kaprodi\DataTransferObjects;

use Modules\Kaprodi\Requests\DosenRequest;

class DosenDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $nidn,
        public ?string $address,
        public ?string $prodi_id,
        public ?string $name_with_title,
        public ?string $phone_number,
        public ?string $scholar_id,
        public ?string $scopus_id,
        public ?string $job_functional,
        public ?string $affiliate_campus,
        public ?string $password,
    ) {}

    public static function fromRequest(DosenRequest $request): self
    {
        return new self(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('nidn'),
            $request->validated('address'),
            $request->validated('prodi_id'),
            $request->validated('name_with_title'),
            $request->validated('phone_number'),
            $request->validated('scholar_id'),
            $request->validated('scopus_id'),
            $request->validated('job_functional'),
            $request->validated('affiliate_campus'),
            $request->password,
        );
    }
}
