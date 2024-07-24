<?php

use App\Domain\Meeting\Models\Meeting;
use App\Domain\User\Models\Integrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('should send emails for meetings', function () {
    Mail::fake();
    $integration = Integrations::factory()->create();
    Meeting::factory(10)->create(['integration_id' => $integration]);

    $responses = [
        Http::response([]),
        Http::response([
            "first_name" => "Woojin",
            "last_name" => "Shin",
            "avatar" => "https://media-exp1.licdn.com/dms/image/C4E03AQE18QqWycaVXw/profile-displayphoto-shrink_200_200/0/1617667686101?e=1664409600&v=beta&t=KoVixUXURtvsxO1Y11f281Re4i1DL1W8cOmtm-SVXJ4",
            "title" => "Manager, North America Business Development",
            "linkedin_url" => "https://www.linkedin.com/in/woojinxshin",
            "company" => [
                "name" => "Algolia",
                "linkedin_url" => "https://www.linkedin.com/company/algolia",
                "employees" => 700
            ]
        ])
    ];

    Http::fake([
        '*' => $responses,
    ]);

    $this->artisan('integration:meetings-emails')->assertSuccessful();

    Mail::assertSentCount(10);
    $this->assertEquals(0, Meeting::dispatch()->count());
});

it('should not send emails for meetings already dispatched', function () {
    Mail::fake();
    $integration = Integrations::factory()->create();
    Meeting::factory(10)->create([
        'integration_id' => $integration,
        'dispatched' => true
    ]);

    $this->artisan('integration:meetings-emails')->assertSuccessful();

    Http::fake();
    Http::assertNothingSent();
    Mail::assertNothingSent();
});
