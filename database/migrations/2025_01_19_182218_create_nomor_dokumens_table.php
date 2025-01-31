<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nomor_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('nomor');
            $table->string('kode_dokumen');
            $table->string('jenis_dokumen');
            $table->string('tahun_dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_dokumens');
    }
};
