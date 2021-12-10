<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstParkingMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_parking_menu', function (Blueprint $table) {
            $table->integerIncrements('menu_cd');
            $table->unsignedBigInteger('parking_cd');
            $table->bigInteger('owner_cd');
            $table->tinyInteger('month_flg')->default(1);
            $table->integer('month_price')->default(0);
            $table->tinyInteger('minimum_use')->nullable();
            $table->tinyInteger('period_flg')->default(0);
            $table->tinyInteger('period_week')->nullable();
            $table->tinyInteger('period_monday')->nullable();
            $table->tinyInteger('period_tuesday')->nullable();
            $table->tinyInteger('period_wednesday')->nullable();
            $table->tinyInteger('period_thursday')->nullable();
            $table->tinyInteger('period_friday')->nullable();
            $table->tinyInteger('period_saturday')->nullable();
            $table->tinyInteger('period_sunday')->nullable();
            $table->tinyInteger('period_holiday')->nullable();
            $table->tinyInteger('period_timeflg')->nullable();
            $table->string('period_fromtime', 5)->nullable();
            $table->string('period_totime', 5)->nullable();
            $table->tinyInteger('period_dayflg')->nullable();
            $table->string('period_fromday', 10)->nullable();
            $table->string('period_today', 10)->nullable();
            $table->integer('period_price')->nullable()->default(0);
            $table->tinyInteger('day_flg')->default(1);
            $table->integer('day_price')->default(0);
            $table->tinyInteger('time_flg')->default(1);
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parking_cd')->references('parking_cd')->on('tbl_parking_lot');
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
        Schema::dropIfExists('mst_parking_menu');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
