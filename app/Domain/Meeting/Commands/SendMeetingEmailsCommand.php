<?php

namespace App\Domain\Meeting\Commands;

use AllowDynamicProperties;
use App\Domain\Meeting\Jobs\MeetingDetailEmailJob;
use App\Domain\Meeting\Models\Meeting;
use App\Domain\Meeting\Models\Participants;
use App\Domain\User\Actions\GetUserInfoAction;
use App\Domain\User\DTOs\UserDto;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    private array $hostEmails = [];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->participantInfo = app(GetUserInfoAction::class);
        $hostMeetings = Meeting::dispatch()->get()->groupBy('host');
        $this->hostEmails = array_keys($hostMeetings->toArray());

        foreach ($hostMeetings as $hostEmail => $meetings) {
            try {
                $data = $this->process($hostEmail, $meetings);
                $this->sendMail($data);
            } catch (\Exception $e) {
                Log::error($e);
            }
        }

    }

    private function sendMail(UserDto $data) {
        Mail::to($data->email)
            ->send(new MeetingDetailEmailJob($data));

        Meeting::whereIn('id', $data->meetings->pluck('id'))
            ->update(['dispatched' => true]);
    }

    private function process(string $hostEmail, Collection $meetings)
    {
        $hostData = $this->participantInfo->execute($hostEmail);
        $company = $hostData->company;
        foreach ($meetings as $meeting) {
            $datesFormat = $this->formatMeetingDate($meeting);
            $meeting->start = $datesFormat['start'];
            $meeting->end = $datesFormat['end'];
            $meeting->duration = $datesFormat['duration'];

            $meeting->participants = Participants::where('meeting_id', $meeting->id)
                ->whereNotIn('email', $this->hostEmails)
                ->get()
                ->map(function ($participant) use (&$company) {
                    $participant->info = $this->participantInfo->execute($participant->email);
                    $participant->full_name = $participant->info->first_name ?
                        "{$participant->info->first_name} {$participant->info->last_name}"
                        : explode('@', $participant->info->email)[0];;

                    if (!$company && $participant->info->company) {
                        $company = $participant->info->company;
                    }

                    $extraData = $this->getExtraData($participant->email);
                    $participant->totalMeetings = $extraData['totalMeetings'];
                    $participant->meetingWith = $extraData['meetingWith'];

                    return $participant;
                });
        }
        $hostData->meetings = $meetings;
        $hostData->company = $company;
        return $hostData;
    }

    private function getExtraData(string $participantEmail): array
    {
        $participantMeetings = Participants::select('id', 'email', 'meeting_id')
            ->where('email', $participantEmail)
            ->pluck('meeting_id');

        $meetintWithCount = Participants::whereIn('email', $this->hostEmails)
            ->whereIn('meeting_id', $participantMeetings)
            ->select('email', DB::raw('count(*) as total_meetings'))
            ->groupBy('email')
            ->get()
            ->pluck('total_meetings', 'email')
            ->mapWithKeys(function($count, $email) {
                $username = explode('@', $email)[0];
                return [$username => $count];
            });

        return [
            'totalMeetings' => $participantMeetings->count(),
            'meetingWith' => $meetintWithCount
        ];
    }

    private function formatMeetingDate(Meeting $meeting): array
    {
        $start = Carbon::parse($meeting->start);
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
}
