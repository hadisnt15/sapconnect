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
            SyncLog::create([
                'name'      => 'dashboard',
                'desc'      => 'Otomatis',
                'last_sync' => now(),
            ]);
        })->everyThirtyMinutes()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

        $schedule->call(function () {
            Artisan::call('sync:oitm');
            SyncLog::create([
                'name' => 'oitm',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->hourly()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

        $schedule->call(function () {
            Artisan::call('sync:ocrd');
            SyncLog::create([
                'name' => 'ocrd',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->hourly()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

        $schedule->call(function () {
            Artisan::call('sync:ordr');
            SyncLog::create([
                'name' => 'ordr',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->everyThirtyMinutes()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

        $schedule->call(function () {
            Artisan::call('sync:oslp');
            SyncLog::create([
                'name' => 'oslp',
                'desc' => 'Otomatis',
                'last_sync' => now()
            ]);
        })->daily();

        $schedule->call(function () {
            $startDate = now()->startOfMonth()->format('d.m.Y');
            $endDate   = now()->endOfMonth()->format('d.m.Y');
            $tahun     = now()->year;
            $bulan     = now()->month;
            Artisan::call('sync:reportLubRetail', [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'tahun' => $tahun,
                'bulan' => $bulan,
            ]);
            SyncLog::create([
                'name' => 'report.penjualan-lub-retail',
                'last_sync' => now(),
                'desc' => 'Otomatis'
            ]);
        })->everyTwoHours()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

        $schedule->call(function () {
            $startDate = now()->startOfMonth()->format('d.m.Y');
            $endDate   = now()->endOfMonth()->format('d.m.Y');
            $tahun     = now()->year;
            $bulan     = now()->month;
            Artisan::call('sync:reportTop10LubRetail', [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'tahun' => $tahun,
                'bulan' => $bulan,
            ]);
            SyncLog::create([
                'name' => 'report.top-10-lub-retail',
                'last_sync' => now(),
                'desc' => 'Otomatis'
            ]);
        })->everyTwoHours()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

        $schedule->call(function () {
            $startDate = now()->startOfMonth()->format('d.m.Y');
            $endDate   = now()->endOfMonth()->format('d.m.Y');
            $tahun     = now()->year;
            $bulan     = now()->month;
            Artisan::call('sync:reportBulananAverage', [
                'startDate' => $startDate,
                'endDate' => $endDate,
                'tahun' => $tahun,
                'bulan' => $bulan,
            ]);
            SyncLog::create([
                'name' => 'report.bulanan-dan-average',
                'last_sync' => now(),
                'desc' => 'Otomatis'
            ]);
        })->hourly()->when(function () {
            return now()->between(now()->setTime(8, 0), now()->setTime(20, 0));
        });

    })
    ->create();
