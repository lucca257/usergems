<?php

namespace App\Domain\User\DTOs;

use App\Domain\Company\Dtos\CompanyDto;
use App\Infrastructure\Helpers\BaseDto;

class UserDto extends BaseDto
{
    public function __construct(
        public string $email,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $avatar,
        public ?string $title,
        public ?string $linkedin_url,
        public ?CompanyDto $company
    ) {
    }
}
