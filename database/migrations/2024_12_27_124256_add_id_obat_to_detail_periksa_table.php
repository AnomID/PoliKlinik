<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdObatToDetailPeriksaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_periksa', function (Blueprint $table) {
            $table->foreignId('id_obat')->nullable()->after('id_periksa')->constrained('obats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_periksa', function (Blueprint $table) {
            $table->dropForeign(['id_obat']);
            $table->dropColumn('id_obat');
        });
    }
}
