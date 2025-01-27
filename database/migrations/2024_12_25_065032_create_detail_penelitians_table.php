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
        Schema::create('detail_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_penelitian_id')
                ->nullable()->references(
                    'id'
                )->on('anggota_penelitian')
                ->cascadeOnDelete();
            $table->foreignId('penelitian_id')
                ->nullable()->references(
                    'id'
                )->on('penelitian')
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
        Schema::dropIfExists('detail_penelitian');
    }
};
