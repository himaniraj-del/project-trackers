<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the overdue task flagging command to run daily at 9:00 AM
Schedule::command('tasks:flag-overdue')->dailyAt('09:00');
