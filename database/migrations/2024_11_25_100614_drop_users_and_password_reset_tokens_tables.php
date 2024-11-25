<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }

    public function down(): void
    {
        Schema::create('users', function ($table) {
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

        Schema::create('password_reset_tokens', function ($table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
};
