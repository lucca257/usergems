<?php

namespace App\Domain\Meeting\DTOs;

use App\Domain\Company\DTOs\CompanyDto;
use App\Infrastructure\Helpers\BaseDto;

class MeetingEmailDTO extends BaseDto
{
    public function __construct(
        public string $host,
        public string $changed,
        public string $start,
        public string $end,
        public string $duration,
        public string $title,
        public array $participants,
        public ?CompanyDto $company,
    ) {
    }
}
