<?php

namespace App\Domain\Meeting\Actions;

use App\Domain\Meeting\DTOs\MeetingDTO;
use App\Domain\Meeting\DTOs\MeetingLists;
use App\Domain\User\Models\Integrations;
use Illuminate\Support\Facades\Http;

class ListMeetingsAction
{
    private const string URL_SUFIX = 'hiring/calendar-challenge/events?page=';

    public function execute(Integrations $integration, int $page): MeetingLists
    {
        $meetingData = $this->request($integration, $page);
        $data = [];

        foreach ($meetingData->data as $meeting) {
            $data[] = new MeetingDTO(
                $meeting->id,
                $meeting->changed,
                $meeting->start,
                $meeting->end,
                $meeting->title,
                $meeting->accepted,
                $meeting->rejected,
            );
        }

        $totalPages = ceil($meetingData->total / $meetingData->per_page);
        return new MeetingLists($page, $totalPages, $data);
    }

    private function request(Integrations $integration, int $page): ?object
    {
        $url = env('INTEGRATION_API').self::URL_SUFIX.$page;

        return Http::withToken($integration->token)->get($url)->object();
    }
}
