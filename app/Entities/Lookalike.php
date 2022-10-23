<?php

namespace App\Entities;

use Illuminate\Support\Arr;

class Lookalike extends Entity
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $username,
        public readonly string $url,
    ) {}

    public static function make(array $data): self
    {
//        dd($data);
        return new self(
            Arr::get($data, 'user_id'),
            Arr::get($data, 'username'),
            Arr::get($data, 'url'),
        );
    }
}
