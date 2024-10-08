<?php

namespace App\Domain\Meeting\DTOs;

use AllowDynamicProperties;
use App\Infrastructure\Helpers\BaseDto;

#[AllowDynamicProperties]
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
        public int $integration_id,
        public string $host
    ) {
    }
}
