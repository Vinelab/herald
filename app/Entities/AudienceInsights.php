<?php

namespace App\Entities;

use App\Collections\PostsCollection;
use Illuminate\Support\Arr;

class AudienceInsights extends Entity
{
    public function __construct(
        public readonly int $globalAudienceSize,
        public readonly PostsCollection $posts,
    ) {}

    public static function make(array $data): self
    {
        return new self(
            Arr::get($data, 'user_profile.followers'),
            PostsCollection::make(Arr::get($data, 'user_profile.commercial_posts')),
        );
    }
}
