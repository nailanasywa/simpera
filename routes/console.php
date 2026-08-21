<?php

use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::command('app:kirim-reminder-pengembalian')
//     ->dailyAt('07:00');
Schedule::command('app:kirim-reminder-pengembalian')
    ->everyMinute()
    ->withoutOverlapping()
    ->when(function () {

        $notifikasi = Notifikasi::where(
            'jenis_notifikasi',
            'pengingat_pengembalian'
        )
            ->where('status', 1)
            ->first();

        if (!$notifikasi) {
            return false;
        }

        return now()->format('H:i') ===
            Carbon::parse($notifikasi->waktu)->format('H:i');
    });
