<?php

namespace App\Entities;

use App\Enums\Gender;
use Illuminate\Support\Arr;

class Account extends Entity
{
    public function __construct(
        public readonly string $username,
        public readonly string $platformId,
        public readonly ?Gender $gender = null,
        public readonly array $phoneNumbers = [],
    ) {}

    public static function make(array $data): self
    {
        return new self(
            Arr::get($data, 'username'),
            Arr::get($data, 'user_id'),
            Gender::from(Arr::get($data, 'gender')),
            Arr::get($data, 'phone_numbers'),
        );
    }
}
