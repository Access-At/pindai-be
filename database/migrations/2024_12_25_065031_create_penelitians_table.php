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
            $table->string('semester');
            $table->text('deskripsi');
            $table->string('status_kaprodi')->default(StatusPenelitian::Pending);
            $table->string('status_dppm')->default(StatusPenelitian::Pending);
            $table->string('status_keuangan')->default(StatusPenelitian::Pending);
            $table->text('keterangan')->nullable();
            $table->date('deadline_dppm')->nullable();
            $table->foreignId('luaran_kriteria_id')
                ->nullable()->references(
                    'id'
                )->on('luaran_kriteria')
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
