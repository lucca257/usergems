<?php

use App\Domain\User\Actions\CreateIntegrationAction;
use App\Domain\User\Actions\CreateUserAction;
use App\Domain\User\DTOs\IntegrationDto;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    dd(app(CreateUserAction::class)->execute('stephan@algolia.com'));
});
