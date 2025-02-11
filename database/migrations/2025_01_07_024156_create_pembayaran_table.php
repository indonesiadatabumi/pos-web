<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('id_billing');
            $table->foreign('id_billing')->references('id_billing')->on('billing')->onDelete('cascade')->onUpdate('cascade');
            $table->string('ntp');
            $table->enum('status', ['Menunggu', 'Lunas']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
