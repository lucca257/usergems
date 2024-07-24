<?php

namespace Database\Factories;

use App\Domain\Meeting\Models\Participants;
use App\Domain\User\Models\Integrations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Participants>
 */
class IntegrationsFactory extends Factory
{
    protected $model = Integrations::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'token' => $this->faker->password
        ];
    }
}
