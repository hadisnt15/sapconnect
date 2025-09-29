<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Schedule::command('sync:oitm')->hourly();
// Schedule::command('sync:ocrd')->hourly();
// Schedule::command('sync:oslp')->hourly();