<?php

use App\Domain\User\Models\Integrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

function getParticipants(array $data): array
{
    $merged = [];

    foreach ($data['accepted'] as $email) {
        $merged[] = [
            'email' => $email,
            'confirmed' => true
        ];
    }

    foreach ($data['rejected'] as $email) {
        $merged[] = [
            'email' => $email,
            'confirmed' => false
        ];
    }

    return $merged;
}

it('should create meetings for integration', function () {
    $integration = Integrations::factory()->create();
    $data = [
        [
            "id" => 1,
            "changed" => "2022-06-27 11:32:12",
            "start" => "2022-07-01 09:30:00",
            "end" => "2022-07-01 10:00:00",
            "title" => "UserGems x Algolia",
            "accepted" => [
                "stephan@usergems.com",
                "joss@usergems.com",
                "demi@algolia.com",
                "joshua@algolia.com",
                "woojin@algolia.com"
            ],
            "rejected" => [
                "aletta@algolia.com"
            ]
        ],
        [
            "id" => 8,
            "changed" => "2022-06-14 11:32:12",
            "start" => "2022-06-15 14:30:00",
            "end" => "2022-06-15 15:00:00",
            "title" => "UserGems x Algolia",
            "accepted" => [
                "stephan@usergems.com",
                "demi@algolia.com",
                "joshua@algolia.com",
                "woojin@algolia.com",
                "aletta@algolia.com"
            ],
            "rejected" => [
            ]
        ],
    ];

    Http::fake([
        env('INTEGRATION_API').'hiring/calendar-challenge/events?page=1' => Http::response([
            "total" => 2,
            "per_page" => 2,
            "current_page" => "1",
            "data" => $data
        ]),
    ]);

    $this->artisan('integration:meetings')
        ->assertSuccessful();

    $this->assertDatabaseHas('meetings', [
        'external_id' => $data[0]['id'],
        'title' => $data[0]['title'],
        'host' => $integration->email,
        'integration_id' => $integration->id
    ]);

    $this->assertDatabaseHas('meetings', [
        'external_id' => $data[1]['id'],
        'title' => $data[1]['title'],
        'host' => $integration->email,
        'integration_id' => $integration->id
    ]);

    foreach (getParticipants($data[0]) as $participant) {
        $this->assertDatabaseHas('participants', [
            'email' => $participant['email'],
            'confirmed' => $participant['confirmed'],
            'meeting_id' => 1,
        ]);
    }

    foreach (getParticipants($data[1]) as $participant) {
        $this->assertDatabaseHas('participants', [
            'email' => $participant['email'],
            'confirmed' => $participant['confirmed'],
            'meeting_id' => 2,
        ]);
    }
});
