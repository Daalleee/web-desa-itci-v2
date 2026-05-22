<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bantuan_sosial', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('keterangan')->nullable();
            $table->bigInteger('nominal')->default(0);
            $table->date('tanggal_penyaluran');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bantuan_sosial');
    }
};
