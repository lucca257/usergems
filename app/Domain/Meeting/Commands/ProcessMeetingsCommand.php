<?php

namespace App\Domain\Meeting\Commands;

use App\Domain\Meeting\Actions\CreateMeetingAction;
use App\Domain\Meeting\Actions\ListMeetingsAction;
use App\Domain\User\Models\Integrations;
use Exception;
use Illuminate\Console\Command;

class ProcessMeetingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:meetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync meeting integrations';

    private ListMeetingsAction $listMeetingsAction;

    private CreateMeetingAction $createMeetingAction;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createMeetingAction = app(CreateMeetingAction::class);
        $this->listMeetingsAction = app(ListMeetingsAction::class);

        $startTime = now();

        Integrations::chunkById(100, function ($integrations) {
            foreach ($integrations as $integration) {
                $this->processIntegration($integration);
            }
        });

        $duration = $startTime->diffInSeconds(now());
        $this->info("Sync meetings execution time: {$duration} seconds");
    }

    private function processIntegration(Integrations $integration): void
    {
        $page = 1;

        while (true) {
            $data = $this->listMeetingsAction->execute($integration, $page);

            $this->processMeetings($data->data);

            if ($page === $data->totalPages) {
                break;
            }

            $page++;
        }
    }

    private function processMeetings(array $meetings): void
    {
        foreach ($meetings as $meeting) {
            try {
                $this->createMeetingAction->execute($meeting);
            } catch (Exception $e) {
                $this->error("Failed to create meeting id {$meeting->external_id}. Error: {$e->getMessage()}");
            }
        }
    }
}
