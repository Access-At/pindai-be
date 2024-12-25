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
        Schema::create('anggota_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nidn')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('prodi');
            $table->string('name');
            $table->string('name_with_title')->nullable();
            $table->string('schoolar_id')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('job_functional')->nullable();
            $table->string('affiliate_campus')->nullable();
            $table->boolean('is_leader');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_penelitian');
    }
};
