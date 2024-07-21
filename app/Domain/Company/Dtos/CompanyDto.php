<?php

namespace App\Domain\Company\Dtos;

class CompanyDto
{
    public function __construct(
        public string $name,
        public string $linkedin_url,
        public int $employees
    ) {
    }
}
