<?php

namespace App\Domain\Meeting\Repository;

use Illuminate\Database\Eloquent\Builder;

class MeetingRepository extends Builder
{
    public function dispatch(): self
    {
        return $this->where('dispatched', false);
    }
}
