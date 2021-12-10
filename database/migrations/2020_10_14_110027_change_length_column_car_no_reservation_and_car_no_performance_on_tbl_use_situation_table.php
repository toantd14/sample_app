<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLengthColumnCarNoReservationAndCarNoPerformanceOnTblUseSituationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_use_situation', function (Blueprint $table) {
            $table->string('car_no_reservation', 20)->comment('予約車番')->nullable()->change();
            $table->string('car_no_performance', 20)->comment('実績車番')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_use_situation', function (Blueprint $table) {
            $table->string('car_no_reservation', 10)->comment('予約車番')->nullable()->change();
            $table->string('car_no_performance', 10)->comment('実績車番')->nullable()->change();
        });
    }
}
