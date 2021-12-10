<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblParkingLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_parking_lot', function (Blueprint $table) {
            $table->bigIncrements('parking_cd');
            $table->bigInteger('owner_cd');
            $table->tinyInteger('mgn_flg')->nullable()->default(0);
            $table->string('parking_name', 200);
            $table->string('zip_cd', 7)->nullable();
            $table->tinyInteger('prefectures_cd');
            $table->string('municipality_name', 150);
            $table->string('townname_address', 200);
            $table->string('building_name', 200)->nullable();
            $table->string('latitude', 300);
            $table->string('longitude', 300);
            $table->string('olc', 300)->nullable();
            $table->string('tel_no', 13);
            $table->string('fax_no', 13)->nullable();
            $table->tinyInteger('sales_division')->nullable()->default(0);
            $table->char('sales_start_time', 5)->nullable();
            $table->char('sales_end_time', 5)->nullable();
            $table->tinyInteger('lu_division')->nullable()->default(0);
            $table->char('lu_start_time', 5)->nullable();
            $table->char('lu_end_time', 5)->nullable();
            $table->string('warn', 2000)->nullable();
            $table->string('image1_url', 150)->nullable();
            $table->string('image2_url', 150)->nullable();
            $table->string('image3_url', 150)->nullable();
            $table->string('image4_url', 150)->nullable();
            $table->string('video1_url', 150)->nullable();
            $table->string('video2_url', 150)->nullable();
            $table->string('video3_url', 150)->nullable();
            $table->string('video4_url', 150)->nullable();
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();
            $table->tinyInteger('re_enter')->default(1);
            $table->tinyInteger('local_payoff')->default(1);
            $table->tinyInteger('net_payoff')->default(1);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('tbl_parking_lot');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
