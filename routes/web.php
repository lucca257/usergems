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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    $meeting = Meeting::with('participants')->first();
    $participantInfo = app(GetUserInfoAction::class);

    $participants = [];
    $company = null;

    $data = Participants::with('meeting')
        ->whereIn('email', $meeting->participants->pluck('email'))
        ->get(['email', 'meeting_id'])
        ->groupBy('email')
        ->map(function ($items) use ($participants, $participantInfo) {
            return $items->count();
        });

    foreach ($meeting->participants as $participant) {
        $participantData = $participantInfo->execute($participant->email);
        $participantData->confirmed = $participant->confirmed;
        $participantData->totalMeetings = $data[$participant->email];
        $participantData->full_name = $participantData->first_name ? "$participantData->first_name $participantData->last_name" : $participant->email;
        $participants[] = $participantData;
        if (!$company && $participantData->company) {
            $company = $participantData->company;
        }
    }

    $start = \Illuminate\Support\Carbon::parse($meeting->start);
    $end = Carbon::parse($meeting->end);

    $duration = $start->diffInSeconds($end);

    if ($duration < 3600) {
        $duration = round($duration / 60)." min";
    } else {
        $duration = round($duration / 3600)." hr";
    }

    $meetingDTO = new MeetingEmailDTO(
        $meeting->host,
        $meeting->changed,
        $start->format('h:i A'),
        $end->format('h:i A'),
        $duration,
        $meeting->title,
        $participants,
        $company
    );

    return new MeetingDetailEmailJob($meetingDTO);

    dd(Mail::to("example@mail.com")
        ->sendNow(new MeetingDetailEmailJob($meetingDTO)));

});
