<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblParkingSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_parking_space', function (Blueprint $table) {
            $table->bigIncrements('serial_no')->comment('シリアルNo');
            $table->unsignedBigInteger('parking_cd')->comment('駐車場管理コード');
            $table->integer('child_number')->comment('子番号');
            $table->tinyInteger('parking_form')->nullable()->comment('駐車場形式');
            $table->string('space_symbol', 5)->nullable()->comment('駐車スペース記号');
            $table->string('space_no', 5)->nullable()->comment('駐車スペース番号');
            $table->tinyInteger('kbn_standard')->nullable()->comment('車種_普通');
            $table->tinyInteger('kbn_3no')->nullable()->comment('車種_３ナンバー');
            $table->tinyInteger('kbn_lightcar')->nullable()->comment('車種_軽自動車');
            $table->float('car_width')->nullable()->comment('車幅');
            $table->float('car_length')->nullable()->comment('車長');
            $table->float('car_height')->nullable()->comment('車高');
            $table->float('car_weight')->nullable()->comment('車重');
            $table->string('registered_person', 50)->nullable()->comment('登録者');
            $table->string('updater', 50)->nullable()->comment('更新者');
            $table->timestamps();

            $table->foreign('parking_cd')->references('parking_cd')->on('tbl_parking_lot');
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
        Schema::dropIfExists('tbl_parking_space');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
