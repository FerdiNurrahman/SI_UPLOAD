<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('username')->unique(); // Username harus unik
            $table->string('email')->unique(); // Email harus unik
            $table->string('name'); // Nama pengguna
            $table->string('password'); // Password terenkripsi
            $table->timestamps(); // Menyimpan waktu created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
