<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('detail_periksa', function (Blueprint $table) {
        $table->integer('jumlah')->after('id_obat');
    });
}

public function down()
{
    Schema::table('detail_periksa', function (Blueprint $table) {
        $table->dropColumn('jumlah');
    });
}

};
