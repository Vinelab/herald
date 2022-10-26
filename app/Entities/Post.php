<?php

namespace App\Entities;

use Illuminate\Support\Arr;

class Post extends Entity
{
    public function __construct(
        public readonly string $id,
        public readonly int $views,
        public readonly int $likes,
        public readonly int $comments,
        public readonly string $caption,
        public readonly string $mentions,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            Arr::get($data, 'post_id'),
            Arr::get($data, 'stat.views'),
            Arr::get($data, 'stat.likes'),
            Arr::get($data, 'stat.comments'),
            Arr::get($data, 'caption'),
            Arr::get($data, 'mentions'),
        );
    }
}
