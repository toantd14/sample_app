<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_favorite', function (Blueprint $table) {
            $table->bigIncrements('serial_no');
            $table->unsignedBigInteger('receipt_number');
            $table->unsignedBigInteger('parking_cd');
            $table->bigInteger('user_cd');
            $table->integer('del_flg')->default(1);
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parking_cd')->references('parking_cd')->on('tbl_parking_lot');
            $table->foreign('user_cd')->references('user_cd')->on('mst_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_favorite');
    }
}
