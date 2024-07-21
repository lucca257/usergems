<?php

use App\Domain\User\Actions\CreateIntegrationAction;
use App\Domain\User\DTOs\IntegrationDto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('token');
            $table->timestamps();
        });

        $this->createIntegrations();
    }

    private function createIntegrations(): void
    {
        $integrations = [
            new IntegrationDto('stephan@usergems.com', '7S$16U^FmxkdV!1b'),
            new IntegrationDto('christian@usergems.com', 'Ay@T3ZwF3YN^fZ@M'),
            new IntegrationDto('joss@usergems.com', 'PK7UBPVeG%3pP9%B'),
            new IntegrationDto('blaise@usergems.com', 'c0R*4iQK21McwLww'),
        ];

        $createIntegrationAction = app(CreateIntegrationAction::class);

        foreach ($integrations as $integration) {
            $createIntegrationAction->execute($integration);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
