<?php

namespace App\Domain\Meeting\DTOs;

use App\Infrastructure\Helpers\BaseDto;

class MeetingDTO extends BaseDto
{
    public function __construct(
        public int $external_id,
        public string $changed,
        public string $start,
        public string $end,
        public string $title,
        public array $accepted,
        public array $rejected,
    ) {
    }
}
