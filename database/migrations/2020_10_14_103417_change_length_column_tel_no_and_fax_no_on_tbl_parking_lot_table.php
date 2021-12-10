<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLengthColumnTelNoAndFaxNoOnTblParkingLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_parking_lot', function (Blueprint $table) {
            $table->string('tel_no', 15)->change();
            $table->string('fax_no', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_parking_lot', function (Blueprint $table) {
            $table->string('tel_no', 13)->change();
            $table->string('fax_no', 13)->nullable()->change();
        });
    }
}
