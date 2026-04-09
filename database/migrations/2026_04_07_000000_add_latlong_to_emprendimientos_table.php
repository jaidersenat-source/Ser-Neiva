<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatlongToEmprendimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emprendimientos', function (Blueprint $table) {
            if (!Schema::hasColumn('emprendimientos', 'latitud')) {
                $table->decimal('latitud', 10, 7)->nullable()->after('direccion');
            }
            if (!Schema::hasColumn('emprendimientos', 'longitud')) {
                $table->decimal('longitud', 10, 7)->nullable()->after('latitud');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emprendimientos', function (Blueprint $table) {
            if (Schema::hasColumn('emprendimientos', 'latitud')) {
                $table->dropColumn('latitud');
            }
            if (Schema::hasColumn('emprendimientos', 'longitud')) {
                $table->dropColumn('longitud');
            }
        });
    }
}
