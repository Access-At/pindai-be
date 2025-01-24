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
        Schema::create('detail_pengabdian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_pengabdian_id')
                ->nullable()->references(
                    'id'
                )->on('anggota_pengabdian')
                ->noActionOnDelete();
            $table->foreignId('pengabdian_id')
                ->nullable()->references(
                    'id'
                )->on('pengabdian')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengabdian');
    }
};
