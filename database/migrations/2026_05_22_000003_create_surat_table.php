<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->string('nomor_surat')->unique();
            $table->enum('jenis_surat', ['Domisili', 'Kelahiran', 'Kematian', 'Usaha', 'Tidak Mampu', 'Pindah']);
            $table->text('keperluan');
            $table->string('dibuat_oleh');
            $table->string('ditandatangani_oleh')->default('Kepala Desa ITCI');
            $table->enum('status', ['Diproses', 'Disetujui', 'Ditolak'])->default('Disetujui');
            $table->json('informasi_tambahan')->nullable(); // Untuk data dinamis tambahan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
