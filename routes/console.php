<?php

use Illuminate\Support\Facades\Schedule;

$this->load(__DIR__.'/../app/Domain/Meeting/Commands');

Schedule::command('integration:meetings')->hourly();
Schedule::command('integration:meetings-emails')->dailyAt('07:59');
