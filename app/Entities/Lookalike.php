<?php

namespace App\Entities;
use Illuminate\Support\Arr;

class Lookalike extends Entity
{
    public function __construct(
        public readonly string $platform_id,
        public readonly string $username,
        public readonly string $external_url,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            Arr::get($data, 'used_id'),
            Arr::get($data, 'username'),
            Arr::get($data, 'url'),
        );
    }
}
