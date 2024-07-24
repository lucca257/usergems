<?php

namespace App\Domain\Meeting\Actions;

use App\Domain\Meeting\DTOs\MeetingDTO;
use App\Domain\Meeting\Models\Meeting;
use App\Domain\Meeting\Models\Participants;
use Illuminate\Support\Facades\DB;

class CreateMeetingAction
{
    public function execute(MeetingDTO $meetingDTO)
    {
        return DB::transaction(function () use ($meetingDTO) {
            $meeting = Meeting::updateOrCreate(
                ['external_id' => $meetingDTO->external_id],
                $meetingDTO->toArray(['accepted', 'rejected'])
            );

            $participantsList = [
                ...$meetingDTO->accepted,
                ...$meetingDTO->rejected
            ];

            $existentParticipants = Participants::whereIn('email', $participantsList)
                ->where('meeting_id', $meeting->id)
                ->pluck('email')
                ->flip()
                ->toArray();

            $participantsToCreateData = [];

            foreach ($participantsList as $participant) {
                if (!isset($existentParticipants[$participant])) {
                    $participantsToCreateData[] = [
                        'email' => $participant,
                        'meeting_id' => $meeting->id,
                        'confirmed' => !in_array($participant, $meetingDTO->rejected),
                    ];
                }
            }

            if (!empty($participantsToCreateData)) {
                Participants::insert($participantsToCreateData);
            }

            return $meeting;
        });
    }
}
