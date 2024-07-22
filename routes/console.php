<?php

use Illuminate\Support\Facades\Schedule;

$this->load(__DIR__.'/../app/Domain/Meeting/Commands');

Schedule::command('integration:meetings')->hourly();
