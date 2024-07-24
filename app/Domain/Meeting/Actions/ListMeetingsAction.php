<?php

namespace App\Domain\Meeting\Actions;

use App\Domain\Meeting\DTOs\MeetingDTO;
use App\Domain\Meeting\DTOs\MeetingListDTO;
use App\Domain\User\Models\Integrations;
use Illuminate\Support\Facades\Http;

class ListMeetingsAction
{
    private const string URL_SUFIX = 'hiring/calendar-challenge/events?page=';

    public function execute(Integrations $integration, int $page): MeetingListDTO
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
                $integration->id,
                $integration->email
            );
        }

        $totalPages = ceil($meetingData->total / $meetingData->per_page);
        return new MeetingListDTO($page, $totalPages, $data);
    }

    private function request(Integrations $integration, int $page): ?object
    {
        $url = env('INTEGRATION_API').self::URL_SUFIX.$page;

        return Http::withToken($integration->token)->get($url)->object();
    }
}
