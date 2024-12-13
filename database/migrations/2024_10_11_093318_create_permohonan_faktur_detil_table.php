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
        Schema::create('permohonan_faktur_detil', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan');
            $table->string('no_seri');
            $table->integer('no_awal');
            $table->integer('no_akhir');
            $table->integer('jml_lembar');
            $table->integer('tarif');
            $table->integer('total');
            $table->enum('status', ['Diterima', 'Menunggu', 'Ditolak']);
            $table->timestamps();
            $table->foreign('no_permohonan')->references('no_permohonan')->on('permohonan_faktur')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_faktur_detil');
    }
};
