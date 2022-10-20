<?php

namespace App\Collections;

use App\Entities\Post;
use Illuminate\Support\Collection;

class PostsCollection extends Collection
{
    public static function make($items = []): self
    {
        $posts = collect($items)->transform(fn($item) => Post::make($item));

        return new self($posts);
    }
}
