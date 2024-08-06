<?php

namespace App\Domain\Meeting\Commands;

use App\Domain\Meeting\Jobs\MeetingDetailEmailJob;
use App\Domain\Meeting\Models\Meeting;
use App\Domain\Meeting\Models\Participants;
use App\Domain\User\Actions\GetUserInfoAction;
use App\Domain\User\DTOs\UserDto;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
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

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->participantInfo = app(GetUserInfoAction::class);
        $hostMeetings = Meeting::all()->groupBy('host');

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

    private function process($hostEmail, $meetings)
    {
        $participantData = $this->participantInfo->execute($hostEmail);
        $company = $participantData->company;
        foreach ($meetings as $meeting) {
            $datesFormat = $this->formatMeetingDate($meeting);
            $meeting->start_formated = $datesFormat['start'];
            $meeting->end_formated = $datesFormat['end'];
            $meeting->duration = $datesFormat['duration'];

            $meeting->participants = Participants::where('meeting_id', $meeting->id)
                ->get()
                ->map(function ($participant) use (&$company) {
                    $participant->info = $this->participantInfo->execute($participant->email);
                    $participant->full_name = $participant->info->first_name ?
                        "{$participant->info->first_name} {$participant->info->last_name}"
                        : $participant->info->email;
                    if (!$company && $participant->info->company) {
                        $company = $participant->info->company;
                    }
                    $participant->totalMeetings = Participants::where('email', $participant->email)->count();
                    return $participant;
                });
        }
        $participantData->meetings = $meetings;
        $participantData->company = $company;
        return $participantData;
    }

    private function formatMeetingDate($meeting): array
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
}
