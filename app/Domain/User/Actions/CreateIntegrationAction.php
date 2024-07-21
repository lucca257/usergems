<?php

namespace App\Domain\User\Actions;

use App\Domain\User\DTOs\IntegrationDto;
use App\Domain\User\Models\Integrations;

class CreateIntegrationAction
{
    public function execute(IntegrationDto $integrationDto): Integrations
    {
        return Integrations::create($integrationDto->toArray());
    }
}
