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
    Schema::table('detail_periksa', function (Blueprint $table) {
        $table->foreignId('id_periksa')
              ->constrained('periksa')
              ->onDelete('cascade')
              ->onUpdate('cascade');
    });
}

public function down(): void
{
    Schema::table('detail_periksa', function (Blueprint $table) {
        $table->dropForeign(['id_periksa']);
        $table->dropColumn('id_periksa');
    });
}

};
