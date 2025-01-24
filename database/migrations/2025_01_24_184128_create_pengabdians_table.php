<?php

use App\Enums\StatusPenelitian;
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
        Schema::create('pengabdian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('judul');
            $table->string('tahun_akademik');
            $table->string('bidang');
            $table->string('semester');
            $table->text('deskripsi');
            $table->string('status_kaprodi')->default(StatusPenelitian::Pending);
            $table->string('status_dppm')->default(StatusPenelitian::Pending);
            $table->string('status_keuangan')->default(StatusPenelitian::Pending);
            $table->text('keterangan')->nullable();
            $table->foreignId('jenis_pengabdian_id')
                ->nullable()->references(
                    'id'
                )->on('jenis_pengabdian')
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
        Schema::dropIfExists('pengabdian');
    }
};
