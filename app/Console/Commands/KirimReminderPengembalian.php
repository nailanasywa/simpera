<?php

namespace App\Console\Commands;

use App\Mail\ReminderPengembalianMail;
use App\Models\Peminjaman;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:kirim-reminder-pengembalian')]
#[Description('Mengirim email reminder pengembalian rekam medis')]
class KirimReminderPengembalian extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $peminjamans = Peminjaman::with('pasien', 'kunjungan.poli', 'permintaan.user.poli',)
            ->where('status_peminjaman', 'dipinjam')
            ->whereNull('tanggal_kembali')
            // ->where('status_pengingat', 'belum')
            ->whereDate('tanggal_jatuh_tempo', '<=', now())
            ->get();

        foreach ($peminjamans as $peminjaman) {

            $email = null;

            if ($peminjaman->jenis_peminjaman == 'kunjungan') {
                $email = $peminjaman->kunjungan?->poli?->email;
            } else {
                $email = $peminjaman->permintaan?->user?->poli?->email;
            }

            if (empty($email)) {
                $this->warn("Email tujuan untuk peminjaman ID {$peminjaman->id} tidak ditemukan.");
                continue;
            }

            Mail::to($email)
                ->queue(new ReminderPengembalianMail($peminjaman));

            $peminjaman->update([
                'status_pengingat' => 'terkirim',
            ]);

            $this->info("Reminder dikirim ke {$email}");
        }

        $this->info('Selesai memproses reminder pengembalian.');
    }
}
