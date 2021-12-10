<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbnailVideoToTblParkingLot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_parking_lot', function (Blueprint $table) {
            $table->string('thumbnail_video')->default("{\"thumbnail1_url\":\"images\/default.png\",\"thumbnail2_url\":\"images\/default.png\",\"thumbnail3_url\":\"images\/default.png\",\"thumbnail4_url\":\"images\/default.png\"}")->after('video4_url');
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
            //
        });
    }
}
