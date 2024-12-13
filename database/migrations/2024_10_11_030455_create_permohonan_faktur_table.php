<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanFakturTable extends Migration
{
    public function up()
    {
        Schema::create('permohonan_faktur', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->unique();
            $table->string('nm_wr');
            $table->string('nama');
            $table->string('npwrd');
            $table->string('alamat_usaha');
            $table->string('no_handphone');
            $table->string('pemilik');
            $table->string('kd_rekening', 20);
            // $table->enum('status', ['Diterima', 'Menunggu', 'Ditolak']);
            $table->timestamps();

            $table->foreign('kd_rekening')->references('kd_rekening')->on('jenis_retribusi')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreign('npwrd')->references('npwrd')->on('daftar_usaha')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_faktur');
    }
}
