<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_question', function (Blueprint $table) {
            $table->id('serial_no');
            $table->unsignedBigInteger('category_id');
            $table->string('title_name', 30);
            $table->string('contents', 1000)->nullable();
            $table->tinyInteger('del_flg')->default(0);
            $table->string('registered_person', 50)->nullable();
            $table->string('updater', 50)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('mst_question_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_question');
    }
}
