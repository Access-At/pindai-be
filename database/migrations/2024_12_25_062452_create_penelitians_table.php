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
        Schema::create('penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('judul');
            $table->string('tahun_akademik');
            // $table->enum('semester', ['ganjil', 'genap']);
            $table->string('semester');
            $table->text('deskripsi');
            $table->string('status_kaprodi');
            $table->string('status_dppm');
            $table->foreignId('jenis_penelitian_id')
                ->nullable()->references(
                    'id'
                )->on('jenis_penelitian')
                ->noActionOnDelete();
            $table->foreignId('jenis_indeksasi_id')
                ->nullable()->references(
                    'id'
                )->on('jenis_indeksasi')
                ->noActionOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitian');
    }
};
