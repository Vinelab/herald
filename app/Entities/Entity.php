<?php

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

abstract class Entity implements Arrayable
{
    public function toArray(): array
    {
        $data = [];

        foreach ($this as $property => $value)
        {
            $name = Str::snake($property);

            // Is property an instance of Arrayable?
            $property = $this->{$property};
            if ($property instanceof Arrayable) {
                $property = $property->toArray();
            }

            $data[$name] = $property;
        }

        return $data;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), 0);
    }
}
