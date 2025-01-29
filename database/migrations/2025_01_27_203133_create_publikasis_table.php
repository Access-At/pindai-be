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
        Schema::create('publikasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->foreignId('jenis_publikasi')
                ->nullable()->references(
                    'id'
                )->on('luaran')
                ->noActionOnDelete();
            $table->date('tanggal_publikasi');
            $table->string('tahun');
            $table->string('authors');
            $table->text('jurnal');
            $table->text('link_publikasi');
            $table->string('status_kaprodi')->default(StatusPenelitian::Pending);
            $table->string('status_dppm')->default(StatusPenelitian::Pending);
            $table->string('status_keuangan')->default(StatusPenelitian::Pending);
            $table->dateTime('status_kaprodi_date')->nullable();
            $table->dateTime('status_dppm_date')->nullable();
            $table->dateTime('status_keuangan_date')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('luaran_kriteria_id')
                ->nullable()->references(
                    'id'
                )->on('luaran_kriteria')
                ->noActionOnDelete();
            $table->foreignId('user_id')
                ->references(
                    'id'
                )->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi');
    }
};
