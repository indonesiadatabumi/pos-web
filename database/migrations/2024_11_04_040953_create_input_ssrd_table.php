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
        Schema::create('input_ssrd', function (Blueprint $table) {
            $table->id();
            $table->string('ssrd_no_seri');
            $table->integer('ssrd_no_awal');
            $table->integer('ssrd_no_akhir');
            $table->integer('ssrd_jml_lembar');
            $table->integer('ssrd_sisa');
            $table->integer('ssrd_tarif');
            $table->integer('ssrd_nilai_setor');
            // $table->string('metode_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_ssrd');
    }
};
