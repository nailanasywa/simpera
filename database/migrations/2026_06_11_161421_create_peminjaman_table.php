<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->restrictOnDelete();
            $table->foreignId('kunjungan_id')->nullable()->constrained('kunjungan')->nullOnDelete();
            $table->foreignId('permintaan_peminjaman_id')->nullable()->constrained('permintaan_peminjaman')->nullOnDelete();
            $table->enum('jenis_peminjaman', ['kunjungan', 'non_kunjungan']);
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_jatuh_tempo');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->integer('jumlah_hari_terlambat')->default(0);
            $table->enum('status_pengingat', ['belum', 'terkirim'])
                ->default('belum');
            $table->enum('status_peminjaman', ['dipinjam', 'selesai'])->default('dipinjam');
            $table->foreignId('user_peminjam')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('user_pengembali')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
