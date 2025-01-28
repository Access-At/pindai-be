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
        Schema::create('luaran_kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('nominal');
            $table->string('terbilang');
            $table->string('keterangan');
            $table->foreignId('luaran_id')->constrained('luaran')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luaran_kriteria');
    }
};
