<?php

namespace Database\Factories;

use App\Domain\Meeting\Models\Meeting;
use App\Domain\User\Models\Integrations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meeting>
 */
class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->uuid(),
            'integration_id' => Integrations::factory(),
            'title' => $this->faker->title,
            'host' => $this->faker->email,
            'changed' => now(),
            'start' => now(),
            'end' => now()->addHour()
        ];
    }
}
