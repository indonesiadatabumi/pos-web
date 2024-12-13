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
        Schema::create('detil_jenis_retribusi_usaha', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daftar_id');
            $table->string('kd_rekening', 20);
            $table->boolean('nilai_checkbox')->default(0);
            $table->foreign('daftar_id')->references('id')->on('daftar_usaha')->onDelete('cascade');
            $table->foreign('kd_rekening')->references('kd_rekening')->on('jenis_retribusi')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detil_jenis_retribusi_usaha');
    }
};
