<?php

namespace App\Entities;

class CreatorInsights extends Entity
{
    public function __construct(
        public readonly Account $account,
        public readonly AudienceInsights $audience,
    ) {}

    public static function make(Account $account, AudienceInsights $audience): self
    {
        return new self($account, $audience);
    }
}
