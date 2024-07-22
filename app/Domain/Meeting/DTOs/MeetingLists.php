<?php

namespace App\Domain\Meeting\DTOs;

class MeetingLists
{
    public function __construct(
        public int $currentPage,
        public int $totalPages,
        public array $data,
    ) {
    }
}
