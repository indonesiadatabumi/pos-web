<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifikasiPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifikasi_permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('no_permohonan')->unique();
            $table->string('nm_wr');
            $table->string('nama');
            $table->string('npwrd');
            $table->string('alamat_usaha');
            $table->string('no_handphone');
            $table->string('pemilik');
            $table->string('kd_rekening', 20);
            // $table->string('no_seri');
            // $table->integer('no_awal');
            // $table->integer('no_akhir');
            // $table->integer('jml_lembar');
            // $table->integer('tarif');
            // $table->integer('total');
            // $table->timestamp('tanggal_permohonan');
            // $table->enum('status', ['Diterima', 'Menunggu', 'Ditolak']);
            $table->timestamps();
            $table->foreign('npwrd')->references('npwrd')->on('daftar_usaha')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('no_permohonan')->references('no_permohonan')->on('permohonan_faktur')
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
        Schema::dropIfExists('verifikasi_permohonan');
    }
}
