<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_review', function (Blueprint $table) {
            $table->bigIncrements('serial_no');
            $table->unsignedBigInteger('receipt_number');
            $table->unsignedBigInteger('parking_cd');
            $table->bigInteger('user_cd');
            $table->string('comment', 3000)->nullable();
            $table->string('registered_person', 50);
            $table->string('updater', 50);
            $table->float('evaluation_satisfaction')->nullable();
            $table->float('evaluation_location')->nullable();
            $table->float('evaluation_ease_stopping')->nullable();
            $table->float('evaluation_fee')->nullable();


            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parking_cd')->references('parking_cd')->on('tbl_parking_lot');
            $table->foreign('user_cd')->references('user_cd')->on('mst_user');
            $table->foreign('receipt_number')->references('receipt_number')->on('tbl_use_situation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_review');
    }
}
