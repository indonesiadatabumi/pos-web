<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarUsahaTable extends Migration
{
    public function up()
    {
        Schema::create('daftar_usaha', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->string('npwrd')->unique();
            $table->string('nm_wr')->unique();
            $table->string('kd_rekening', 20);
            $table->foreign('kd_rekening')->references('kd_rekening')->on('jenis_retribusi')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama');
            $table->string('email');
            $table->string('kota');
            $table->char('kd_kelurahan', 20);
            $table->char('kd_kecamatan', 20);
            // $table->string('tempat_lahir'); 
            // $table->date('tanggal_lahir'); 
            // $table->string('alamat');
            $table->foreign('kd_kecamatan')->references('kd_kecamatan')->on('kecamatan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kd_kelurahan')->references('kd_kelurahan')->on('kelurahan')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_handphone');
            // $table->string('no_rekening')->nullable(); 
            $table->string('alamat_usaha');
            $table->string('pemilik');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daftar_usaha');
    }
}
