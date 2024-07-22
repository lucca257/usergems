<?php

namespace App\Domain\Company\DTOs;

class CompanyDto
{
    public function __construct(
        public string $name,
        public string $linkedin_url,
        public int $employees
    ) {
    }
}
