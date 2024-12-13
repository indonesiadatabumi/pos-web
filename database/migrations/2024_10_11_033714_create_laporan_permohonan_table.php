<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('npwrd', 21);
            $table->string('nm_wr', 21);
            $table->string('nama', 100);
            $table->string('alamat_usaha', 255);
            $table->string('no_awal', 20);
            $table->string('no_akhir', 20);
            $table->integer('jml_lembar');
            // $table->timestamp('tanggal_permohonan');
            $table->timestamps();
            $table->foreign('npwrd')->references('npwrd')->on('permohonan_faktur')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_permohonan');
    }
}
