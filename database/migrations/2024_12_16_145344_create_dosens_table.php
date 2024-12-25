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
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->string('name_with_title')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('scholar_id')->unique()->nullable();
            $table->string('scopus_id')->unique()->nullable();
            $table->string('job_functional')->nullable();
            $table->string('affiliate_campus')->nullable();
            $table->foreignId('user_id')
                ->nullable()->references(
                    'id'
                )->on('users')
                ->onDelete('cascade');
            $table->foreignId('prodi_id')
                ->nullable()->references(
                    'id'
                )->on('prodi')
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
        Schema::dropIfExists('dosen');
    }
};
