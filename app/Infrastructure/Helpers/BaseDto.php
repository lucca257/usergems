<?php

namespace App\Infrastructure\Helpers;

class BaseDto
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
