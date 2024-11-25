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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('username')->unique(); 
            $table->string('fullname'); 
            $table->string('email')->unique(); 
            $table->string('password'); 
            $table->rememberToken(); 
            $table->integer('status_aktif')->default(1); 
            $table->unsignedBigInteger('role_id'); 
            $table->unsignedBigInteger('daftar_id')->nullable();
            $table->timestamps(); 

         
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade'); 
            $table->foreign('daftar_id')->references('id')->on('daftar_usaha')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); 
        });
        Schema::table('daftar_usaha', function (Blueprint $table){
            $table->dropForeign(['daftar_id']);
        });
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};