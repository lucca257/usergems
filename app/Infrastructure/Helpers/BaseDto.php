<?php

namespace App\Infrastructure\Helpers;

class BaseDto
{
    public function toArray(?array $ignore = null): array
    {
        $properties = get_object_vars($this);

        if (is_array($ignore)) {
            $properties = array_filter($properties, function ($key) use ($ignore) {
                return !in_array($key, $ignore);
            }, ARRAY_FILTER_USE_KEY);
        }

        return $properties;
    }
}
