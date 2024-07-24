<?php

namespace App\Domain\Meeting\Commands;

use App\Domain\Meeting\DTOs\MeetingEmailDTO;
use App\Domain\Meeting\Jobs\MeetingDetailEmailJob;
use App\Domain\Meeting\Models\Meeting;
use App\Domain\Meeting\Models\Participants;
use App\Domain\User\Actions\GetUserInfoAction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendMeetingEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:meetings-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send meeting emails';

    private GetUserInfoAction $participantInfo;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->participantInfo = app(GetUserInfoAction::class);

        Meeting::with('participants')->dispatch()->chunkById(100, function ($meetings) {
            foreach ($meetings as $meeting) {
                $this->process($meeting);
            }
        });
    }

    private function process(Meeting $meeting): void
    {
        $participants = [];
        $company = null;

        $countParticipantsInMeetings = $this->countParticipantsInMeetings($meeting->participants->pluck('email'));

        foreach ($meeting->participants as $participant) {
            $participantData = $this->participantInfo->execute($participant->email);
            $participantData->confirmed = $participant->confirmed;
            $participantData->totalMeetings = $countParticipantsInMeetings[$participant->email];
            $participantData->full_name = $participantData->first_name ? "$participantData->first_name $participantData->last_name" : $participant->email;

            $participants[] = $participantData;

            if (!$company && $participantData->company) {
                $company = $participantData->company;
            }
        }

        $start = Carbon::parse($meeting->start);
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

        Mail::to($meeting->host)
            ->send(new MeetingDetailEmailJob($meetingDTO));

        $meeting->dispatched = true;
        $meeting->save();
    }

    private function countParticipantsInMeetings(Collection $emails)
    {
        return Participants::with('meeting')
            ->whereIn('email', $emails)
            ->get(['email', 'meeting_id'])
            ->groupBy('email')
            ->map(function ($items) {
                return $items->count();
            });
    }
}
