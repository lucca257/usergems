<?php

namespace App\Domain\User\DTOs;

use App\Infrastructure\Helpers\BaseDto;

class IntegrationDto extends BaseDto
{
    public function __construct(
        public string $email,
        public string $token,
        public ?int $id = null,
    ) {
    }
}
