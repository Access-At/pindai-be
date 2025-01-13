<?php

use App\Enums\StatusPenelitian;
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
            $table->string('bidang');
            // $table->enum('semester', ['ganjil', 'genap']);
            $table->string('semester');
            $table->text('deskripsi');
            $table->string('status_kaprodi')->default(StatusPenelitian::Pending);
            $table->string('status_dppm')->default(StatusPenelitian::Pending);
            $table->string('status_keuangan')->default(StatusPenelitian::Pending);
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
