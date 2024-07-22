<?php

namespace App\Domain\Meeting\Commands;

use App\Domain\Meeting\Actions\CreateMeetingAction;
use App\Domain\Meeting\Actions\ListMeetingsAction;
use App\Domain\User\Models\Integrations;
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

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Integrations::chunkById(100, function ($integrations) {
            foreach ($integrations as $integration) {
                $this->process($integration);
            }
        });
    }

    public function process(Integrations $integration): void
    {
        $page = 1;
        $listMeetingAction = app(ListMeetingsAction::class);
        $createMeetingAction = app(CreateMeetingAction::class);

        while (true) {
            $data = $listMeetingAction->execute($integration, $page);

            foreach ($data->data as $meeting) {
                $createMeetingAction->execute($meeting);
            }

            if ($page === $data->totalPages) {
                break;
            }

            $page++;
        }
    }
}
