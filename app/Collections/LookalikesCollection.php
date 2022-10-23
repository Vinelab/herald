<?php

namespace App\Collections;

use App\Entities\Lookalike;
use Illuminate\Support\Collection;

class LookalikesCollection extends Collection
{
    public static function make($items = []): self
    {
        $lookalikes = collect($items)->transform(fn($item) => Lookalike::make($item));

        return new self($lookalikes);
    }
}