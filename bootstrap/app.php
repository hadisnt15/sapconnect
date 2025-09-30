<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\SyncLog;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
        $middleware->web([
            \App\Http\Middleware\CheckUserSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            $startDate = now()->startOfMonth()->format('d.m.Y');
            $endDate   = now()->endOfMonth()->format('d.m.Y');
            $tahun     = now()->year;
            $bulan     = now()->month;

            Artisan::call('sync:dashboard', [
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'tahun'     => $tahun,
                'bulan'     => $bulan,
            ]);

            // simpan log otomatis
            SyncLog::create([
                'name'      => 'dashboard',
                'desc'      => 'Otomatis',
                'last_sync' => now(),
            ]);
        })->everyThirtyMinutes();
        $schedule->call(function () {
            Artisan::call('sync:oitm');
            SyncLog::create([
                'name' => 'oitm',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->everyThirtyMinutes();
        $schedule->call(function () {
            Artisan::call('sync:ocrd');
            SyncLog::create([
                'name' => 'ocrd',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->everyThirtyMinutes();
        $schedule->call(function () {
            Artisan::call('sync:ordr');
            SyncLog::create([
                'name' => 'ordr',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->everyThirtyMinutes();
        $schedule->call(function () {
            Artisan::call('sync:oslp');
            SyncLog::create([
                'name' => 'oslp',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->daily();
    })
    ->create();
