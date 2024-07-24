<?php

namespace App\Domain\Meeting\DTOs;

use App\Infrastructure\Helpers\BaseDto;

class MeetingCountDTO extends BaseDto
{
    public function __construct(
        public int $total,
        public array $participants,
    ) {
    }
}
