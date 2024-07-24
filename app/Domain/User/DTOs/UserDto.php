<?php

namespace App\Domain\User\DTOs;

use AllowDynamicProperties;
use App\Domain\Company\DTOs\CompanyDto;
use App\Domain\Meeting\DTOs\MeetingCountDTO;
use App\Infrastructure\Helpers\BaseDto;

#[AllowDynamicProperties]
class UserDto extends BaseDto
{
    public function __construct(
        public string $email,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $avatar,
        public ?string $title,
        public ?string $linkedin_url,
        public ?CompanyDto $company,
        public ?MeetingCountDTO $meetingCount = null,
    ) {
    }
}
