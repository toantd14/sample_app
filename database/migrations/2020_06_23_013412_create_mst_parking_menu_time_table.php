<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstParkingMenuTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_parking_menu_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('menu_cd');
            $table->tinyInteger('day_type');
            $table->char('from_time', 5);
            $table->char('to_time', 5);
            $table->integer('price');
            $table->string('registered_person')->nullable();
            $table->string('updater')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('menu_cd')->references('menu_cd')->on('mst_parking_menu');
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
        Schema::dropIfExists('mst_parking_menu_time');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
