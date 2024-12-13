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
        Schema::create('jenis_retribusi', function (Blueprint $table) {
            $table->id('id');
            $table->string('kd_rekening', 20)->unique();
            $table->string('nm_retribusi');
            $table->string('dasar_hukum_pengenaan')->nullable();
            $table->boolean('item')->default(0);
            $table->boolean('non_karcis')->default(0);
            $table->boolean('karcis')->default(0);
            $table->boolean('denda')->nullable();
            $table->unsignedBigInteger('fk_denda')->nullable();
            $table->string('lv_kategori')->nullable();
            $table->string('sub_kategori')->nullable();
            $table->string('kode_kategori')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_retribusi');
    }
};
