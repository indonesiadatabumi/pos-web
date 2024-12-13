<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            // $table->string('no_permohonan')->unique();
            $table->string('npwrd');
            // $table->string('nm_wr');
            // $table->string('nama');
            $table->string('id_billing');
            $table->string('ssrd_no_seri');
            $table->integer('ssrd_no_awal');
            $table->integer('ssrd_no_akhir');
            $table->integer('ssrd_jml_lembar');
            $table->integer('ssrd_sisa');
            $table->integer('ssrd_tarif');
            $table->integer('ssrd_nilai_setor');
            // $table->string('metode_bayar');
            // $table->timestamp('tanggal_rekam');
            $table->enum('status', ['Menunggu', 'Lunas']);
            $table->timestamps();
            $table->foreign('npwrd')->references('npwrd')->on('daftar_usaha')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('no_permohonan')->references('no_permohonan')->on('verifikasi_permohonan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing');
    }
}
