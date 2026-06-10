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
        Schema::create('hibahs', function (Blueprint $table) {
            $table->id();
            $table->text('nama_hibah');
            $table->string('sumber');
            $table->string('jenis');
            $table->year('tahun');
            $table->string('ketua_pengusul');
            $table->string('program_studi')->nullable();
            $table->bigInteger('total_diusulkan');
            $table->bigInteger('total_disetujui')->nullable();
            $table->text('judul_deskripsi')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->integer('durasi_bulan')->nullable();
            $table->string('status');
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hibahs');
    }
};
