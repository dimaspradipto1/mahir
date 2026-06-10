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
            $table->string('total_diusulkan');
            $table->string('total_disetujui');
            $table->string('status');
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
