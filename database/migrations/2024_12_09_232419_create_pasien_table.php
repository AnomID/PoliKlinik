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
    Schema::create('pasien', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 255);
        $table->string('alamat', 255);
        $table->string('no_ktp', 255)->unique();
        $table->string('no_hp', 50);
        $table->string('no_rm', 25)->unique();
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
