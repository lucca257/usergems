<?php

use App\Domain\Meeting\Actions\ListMeetingsAction;
use App\Domain\Meeting\DTOs\MeetingDTO;
use App\Domain\Meeting\DTOs\MeetingEmailDTO;
use App\Domain\Meeting\Jobs\MeetingDetailEmailJob;
use App\Domain\Meeting\Models\Meeting;
use App\Domain\Meeting\Models\Participants;
use App\Domain\User\Actions\CreateUserAction;
use App\Domain\User\Actions\GetUserInfoAction;
use App\Domain\User\Models\Integrations;
use Carbon\Carbon;
use GuzzleHttp\Promise\Promise;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    $hostMeetings = Meeting::all()->groupBy('host');
    $participantInfo = app(GetUserInfoAction::class);
    $dataCollection = collect();

    function formatMeetingDate($meeting): array
    {
        $start = \Illuminate\Support\Carbon::parse($meeting->start);
        $end = Carbon::parse($meeting->end);

        $duration = $start->diffInSeconds($end);

        if ($duration < 3600) {
            $duration = round($duration / 60)." min";
        } else {
            $duration = round($duration / 3600)." hr";
        }

        return [
            'start' => $start->format('h:i A'),
            'end' => $end->format('h:i A'),
            'duration' => $duration
        ];
    }
    $allParticipants = collect();


    foreach ($hostMeetings as $hostEmail => $meetings) {
        $participantData = $participantInfo->execute($hostEmail);
        $company = $participantData->company;

        foreach ($meetings as $meeting) {
            $datesFormat = formatMeetingDate($meeting);
            $meeting->start_formated = $datesFormat['start'];
            $meeting->end_formated = $datesFormat['end'];
            $meeting->duration = $datesFormat['duration'];

            $meeting->participants = Participants::where('meeting_id', $meeting->id)
                ->where('email', '!=', $hostEmail)
                ->get()
                ->map(function ($participant) use ($participantInfo, &$company, $meeting) {
                    $participant->info = $participantInfo->execute($participant->email);
                    $participant->full_name = $participant->info->first_name ?
                        "{$participant->info->first_name} {$participant->info->last_name}"
                        : $participant->info->email;
                    if (!$company && $participant->info->company) {
                        $company = $participant->info->company;
                    }
                    $participant->totalMeetings = Participants::where('email', $participant->email)->count();
                    return $participant;
                });

            $allParticipants = $allParticipants->merge($meeting->participants->pluck('email'));
        }

        $participantData->meetings = $meetings;
        $participantEmails = $allParticipants->unique();

        $emailMeetingDetails = [];

        foreach ($participantEmails as $participantMail) {
            $participantMeetings = Participants::where('email', $participantMail)->get();

            $meetingDetails = [];

            foreach ($participantMeetings as $participantMeeting) {
                $meetingId = $participantMeeting->meeting_id;

                $otherParticipants = Participants::where('meeting_id', $meetingId)
                    ->where('email', '!=', $participantMail)
                    ->pluck('email')
                    ->toArray();

                foreach ($otherParticipants as $otherParticipant) {
                    if (!isset($meetingDetails[$otherParticipant])) {
                        $meetingDetails[$otherParticipant] = 0;
                    }
                    $meetingDetails[$otherParticipant]++;
                }
            }

            $emailMeetingDetails[$participantMail] = $meetingDetails;
        }

        dd($emailMeetingDetails);



        $participantData->company = $company;
        $dataCollection->push($participantData);
    }


dd($dataCollection[2]->meetings[0]->participants->pluck('email'));


});
