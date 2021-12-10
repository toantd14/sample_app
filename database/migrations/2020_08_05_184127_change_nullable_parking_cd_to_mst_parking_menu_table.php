<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableParkingCdToMstParkingMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_parking_menu', function (Blueprint $table) {
            $table->unsignedBigInteger('parking_cd')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_parking_menu', function (Blueprint $table) {
            $table->unsignedBigInteger('parking_cd');
        });
    }
}
