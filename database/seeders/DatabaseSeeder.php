<?php

namespace Database\Seeders;

use App\Domain\User\DTOs\IntegrationDto;
use App\Domain\User\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $integrations = [
            new IntegrationDto('stephan@usergems.com', '7S$16U^FmxkdV!1b'),
            new IntegrationDto('christian@usergems.com', 'Ay@T3ZwF3YN^fZ@M'),
            new IntegrationDto('joss@usergems.com', 'PK7UBPVeG%3pP9%B'),
            new IntegrationDto('blaise@usergems.com', 'c0R*4iQK21McwLww'),
        ];

        foreach ($integrations as $integration) {

        }
    }
}
